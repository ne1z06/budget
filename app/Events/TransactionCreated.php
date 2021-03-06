<?php

namespace App\Events;

use App\Models\Earning;
use App\Models\Activity;
use App\Models\Spending;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Auth;

class TransactionCreated
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct($transaction)
    {
        $userId = null;

        if (Auth::check()) {
            $userId = Auth::user()->id;
        }

        if ($transaction instanceof Earning) {
            $entityType = 'earning';
        }

        if ($transaction instanceof Spending) {
            $entityType = 'spending';
        }

        Activity::create([
            'space_id' => $transaction->space_id,
            'user_id' => $userId,
            'entity_id' => $transaction->id,
            'entity_type' => $entityType,
            'action' => 'transaction.created'
        ]);
    }
}
