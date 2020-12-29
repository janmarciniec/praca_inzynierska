<?php

namespace App\Http\Controllers;

use App\Claim;
use App\Comment;
use App\DeliveryAddress;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use App\Item;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function create(Transaction $transaction)
    {
        $this->authorize('create', [Comment::class, $transaction]);

        return view('comments.create', compact('transaction'));
    }

    public function store(Transaction $transaction, Request $request){
        $data = request() -> validate([
            'comment' => ['required', 'string', 'max:255'],

        ]);
        $data['user_id'] = $transaction->item->user->id;
        $request->ratedindex++;
        $data['rating'] = $request->ratedindex;


        //$rating = mysqli_real_escape_string($_POST['ratedindex']);
        $transaction->comment()->create($data);
        
        $notification = array(
                    'message' => 'Komentarz został dodany',
                    'alert-type' => 'success'
                );

        return redirect()->route('user.index')->with($notification);

    }

    public function show(Comment $comment)
    {
        $this->authorize('view', $comment);

        return view('comments.show', compact('comment'));
    }



    public function usercomments(User $user){
        $comments = Comment::where('user_id', 'LIKE',"$user->id")->orderBy('created_at','DESC')->get();
        return view('comments.usercomments', compact('user','comments'));

    }

}
