<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Review;

class ReviewsController extends Controller
{
    public function index()
    {
        $isUser = Auth::user();
        if (!$isUser) {
            $reviews = DB::table('reviews')->get();
            return view('reviews', ['reviews' => $reviews ]);
        }
        else
        {
            $user = Auth::user()->id;
		    $reviews = DB::table('reviews')->get(); 
            $events_user = DB::table('events_has_users')->where('users_id', '=', $user)->pluck('events_id');
            if (count($events_user)) {
                $events = DB::table('events')->where('id','=', $events_user)->get();
                if (count($events)) {
                    return view('reviews', ['reviews' => $reviews , 'events' => $events ]);
                }
                else
                    return view('reviews', ['reviews' => $reviews ]);
            }
            else
                return view('reviews', ['reviews' => $reviews ]);
        }
        
    }


    public function addReview(Request $request)
	{
        $user = Auth::user();
        $review = new Review;
        $review->events_id = $request->events_id;
        $review->events_name = $request->events_name; 
        $review->users_id = $user->id;
        $review->users_name = $user->name; 
        $review->reviewtext = $request->textbox;   
        $file = $request->file('type_pic');
        $filename= time().'-'.$file->getClientOriginalName();
        $file = $file->move('../public/images/gallery',$filename);
        $review->pic = $filename;
		$review->save();
		return redirect("/reviews/");
	}
}
