<?php
namespace Idsign\Kaleyra\Http\Controllers;

use Idsign\Kaleyra\Kaleyra;
use Illuminate\Support\Facades\Log;

class EventController
{
    private $bandyer;

    public function __construct() {
        $this->bandyer = new Kaleyra();
    }


    protected function response($data = [], $code = 200, $addFormRequest = true)
    {
        $data = is_string($data) ? ['msg' => $data] : $data;
        if (in_array(request()->method(), ['POST', 'PUT']) && $addFormRequest) {
            $data['form_request'] = request()->all();
        }

        if ($code != 200) {
            Log::alert('Response', $data);
        }
        response()->json($data, $code)->send();
        die();
    }

    private function respond(){
        return response()->json($this->bandyer->getContents(), $this->bandyer->getStatus());
    }

    public function configure()
    {
        $res = [];
        $res[] = $this->setConfigure(['on_recording_available', 'on_call_incoming']);
        //$res[] = $this->setConfigure(['on_message_sent'], 'v1/');
        $this->response($res);
    }

    private function setConfigure($filters, $version = '')
    {
        $url = rtrim(config('app.url'), '/') . '/api/sendNotification';

        $headers = [
            'post_event_webhook_url' => $url,
            'webhook_method' => 'POST',
            'webhook_filters' => $filters
        ];

        $this->bandyer->configure([],$headers, $version);
        return $this->respond();
    }

    public function send()
    {
        Log::info('new event', request()->all());
        $event = request('event');
        $data = request('data');
        if (is_string($data)) {
            $data = json_decode($data, true);
        }
        switch ($event) {
            case 'on_recording_available':
                $this->on_recording_available($data);
                break;
            case 'on_call_incoming':
                $this->on_call_incoming($data);
                break;
            case 'on_message_sent':
                $this->on_message_sent($data);
                break;
            default:
                if (config('bandyer.rest.log')) {
                    Log::info(json_encode(request()->all()));
                }
                $this->response("Error: Kaleyra - Event not found", 422);
                break;
        }


    }

    private function on_recording_available($data)
    {
        $room_id = $data['room_id'] ?? 0;
        $session_id = $data['session_id'] ?? null;
        $room = Room::where('bandyer_id', $room_id)->first();
        if (!$room) {
            $this->response("Error: DB - Room not found", 500);
        }
        $room->session_id = $session_id;
        if (!$room->save()) {
            $this->response("Error: DB - Error saving", 500);
        }
        $this->response(['msg' => "Event saved"]);
    }

    private function on_call_incoming($data): void
    {
        $busers = [];
        $name = 'Chiamata in arrivo';
        Log::info('event response', $data);
        $sender = $data['initiator'];
        $call = new Videocall();
        $addCall = true;
        $call->payload = $data;
        $call->config = $data['roomAlias'];
        $caller = User::where('bandyer_id', $sender)->first();
        if ($caller) {
            $call->operator_id = $caller->id;
        } else {
            $addCall = false;
        }
        foreach ($data['users'] as $user) {
            $alias = $user['user']['userAlias'];
            if ($alias !== $sender) {
                $receiver = User::where('bandyer_id', $alias)->first();
                if ($receiver) {
                    $call->user_id = $receiver->id;
                } else {
                    $addCall = false;
                }
            }
            $busers[] = $user['user']['userAlias'];
        }
        if ($addCall) {
            $call->save();
        }
        $voipIds = $this->getVoipIds($busers, $sender);
        if (count($voipIds) > 0) {
            $this->sendVoipNotification($voipIds);
        }
        $this->sendNotification($name, $this->getIds($busers, $sender, true));
    }


    private function on_message_sent($data)
    {
        $name = 'Nuovo messaggio';
        $sender = $data['sender'];
        foreach ($data['participants'] as $user) {
            $busers[] = $user;
        }
        $this->sendNotification($name, $this->getIds($busers, $sender));
    }

    private function getIds($busers, $sender, $isCall = false): array
    {
        $users = User::whereIn('bandyer_id', $busers)->get();
        $bandyer_ids = [];
        foreach ($users as $user) {
            if ($user->bandyer_id != $sender) {
                $sids = $user->info['players'] ?? [];
                foreach ($sids as $sid) {
                    if ($isCall) {
                        if (!$sid['voip']) {
                            $bandyer_ids[] = $sid['push'];
                        }
                    } else {
                        $bandyer_ids[] = $sid['push'];
                    }
                }
            }
        }
        return $bandyer_ids;
    }

    private function getVoipIds($busers, $sender): array
    {
        $users = User::whereIn('bandyer_id', $busers)->get();
        $bandyer_ids = [];
        foreach ($users as $user) {
            if ($user->bandyer_id != $sender) {
                $sids = $user->info['players'] ?? [];
                foreach ($sids as $sid) {
                    if ($sid['voip']) {
                        $bandyer_ids[] = $sid['voip'];
                    }
                }
            }
        }
        return $bandyer_ids;
    }

    private function sendNotification($name, $ids): void
    {
        if (!$ids || empty($ids)) {
            Log::info('sendNotification Failed');
            return;
        }

        $os = new OneSignal(config('onesignal.app_id'), config('onesignal.rest_api_key'), config('onesignal.user_auth_key'));
        Log::info('sendNotification OneSignal');
        $os->sendNotificationToUser(
            $name,
            $ids,
            '',
            request()->all()
        );
    }

    private function sendVoipNotification($ids): void
    {
        if (!$ids || empty($ids)) {
            return;
        }

        $os = new OneSignal(config('onesignal.voip_app_id'), config('onesignal.voip_rest_api_key'), config('onesignal.voip_user_auth_key'));
        $extra = [
            'content_available' => true,
            'apns_push_type_override' => 'voip'
        ];
        $os->sendNotificationToUser(
            false,
            $ids,
            '',
            request()->all(),
            $extra
        );
    }
}
