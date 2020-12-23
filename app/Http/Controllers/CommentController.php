<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cities;
use App\Models\CityComment;


class CommentController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        $request->validate([
            'comment' => 'required|string',
            'city_id' => 'required|int'
        ]);

        $user_id = Auth::user()->id;

        // retrieve city
        $city = Cities::find($request->input('city_id'));

        if (!$city) {
            return response()->json(['message' => 'Not found!'], 404);
        }

        // insert new comment
        $city->comments()->create(['users_id' => $user_id, 'comment' => $request->input('comment')]);

        return response()->json(['message' => 'Comment added successfully!']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'comment' => 'required|string',
            'comment_id' => 'required|int'
        ]);

        // retrieve comment
        $cityComment = CityComment::find($request->input('comment_id'));

        // comment is not found
        if (!$cityComment) {
            return response()->json(['message' => 'Comment Not found!'], 404);
        }

        if(Auth::user()->id != $cityComment->users_id) {
            return response()->json(['message' => 'Unauthorized!'], 403);
        }

        // save comment
        $cityComment->comment = $request->input('comment');
        $cityComment->save();

        return response()->json(['message' => 'Comment updated successfully!']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|int',
        ]);

        // retrieve comment
        $cityComment = CityComment::find($request->input('comment_id'));

        // comment not found
        if (!$cityComment) {
            return response()->json(['message' => 'Not found!'], 404);
        }

        // user is unauthorized
        if (Auth::user()->id != $cityComment->users_id) {
            return response()->json(['message' => 'Unauthorized!'], 403);
        }

        // delete comment
        $cityComment->delete();

        return response()->json(['message' => 'Comment deleted successfully!']);
    }
}
