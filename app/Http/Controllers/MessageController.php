<?php

namespace App\Http\Controllers;

use App\Claim;
use App\Message;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Conversation;

class MessageController extends Controller
{
    public function create(User $user)
    {
        $this->authorize('create', Message::class);

        return view('messages.firstmessage', compact('user'));

    }

    public function store(User $user)
    {
            $conversation = null;
            $user2 = Auth::user();
            $conversation = Conversation::where(['sender_id'=>$user2->id, 'receiver_id'=>$user->id])->orWhere(function ($query)use($user,$user2)
                                                                                                                {$query->where('sender_id','LIKE',"$user->id")
                                                                                                                    ->where('receiver_id','LIKE',"$user2->id");
                                                                                                                })
                                                                                                                    ->first();

            //dd($conversation);
            if ($conversation != null) {
                $data = request()->validate([
                    'message' => ['required', 'string', 'max:255'],
                ]);
                $data['user_id'] = Auth::id();
                $data['conversation_id'] = $conversation->id;

                $conversation->messages()->create($data);

            } else {
                $data2['sender_id'] = Auth::id();
                $data2['receiver_id'] = $user->id;
                $data = request()->validate([
                    'message' => ['required', 'string', 'max:255'],
                ]);
                $conversation2 = $user->conversations()->create($data2);
                $data['user_id'] = Auth::id();
                $data['conversation_id'] = $conversation2->id;

                $conversation2->messages()->create($data);


            }



        return redirect()->route('user.index');
    }

    public function show(User $user){
        $this->authorize('view', Message::class);

        $user = Auth::user();
        $conversations = Conversation::where('sender_id',"LIKE","$user->id")->orWhere('receiver_id',"LIKE","$user->id")->get();
        foreach ($conversations as $conversation){
            if($conversation->receiver_id == $user->id) {
                $conversation->contact = User::where('id',"LIKE","$conversation->sender_id")->first();
            }else{
                $conversation->contact = User::where('id',"LIKE","$conversation->receiver_id")->first();
            }

        }
        return view('messages.inbox', compact('conversations'));
    }

    public function showConversation(Conversation $conversation){
        $this->authorize('show', [Message::class, $conversation]);

        $messages = Message::where('conversation_id',"LIKE","$conversation->id")->orderBy('created_at','ASC')->get();
        //dd($messages);
        return view('messages.conversation', compact('messages','conversation'));

    }

    public function store2(Conversation $conversation)
    {
        $conversation2 = null;
        $user2 = Auth::user();
        if($user2->id == $conversation->receiver_id){
            $id_user = $conversation->sender_id;
        }else{
            $id_user = $conversation->receiver_id;
        }
        $conversation2 = Conversation::where(['sender_id'=>$user2->id, 'receiver_id'=>$id_user])->orWhere(function ($query)use($id_user,$user2)
        {$query->where('sender_id','LIKE',"$id_user")
            ->where('receiver_id','LIKE',"$user2->id");
        })
            ->first();

            $data = request()->validate([
                'message' => ['required', 'string', 'max:255'],
            ]);
            $data['user_id'] = $user2->id;
            $data['conversation_id'] = $conversation2->id;

            $conversation2->messages()->create($data);


        return redirect()->route('message.conversation', compact('conversation'));
    }

}
