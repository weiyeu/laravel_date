<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketFormRequest;
use App\Ticket;
use Mail;
use App;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $router1 = App::make('router');
//        $test = 'aaa';
//        App::instance('router',$test);
//        $router2 = App::make('router');
        $tickets = Ticket::all();
        return view('tickets.index')
            ->with('tickets', $tickets);
//            ->with('router1', $router1)
//            ->with('router2', $router2);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketFormRequest $request)
    {
        $slug = uniqid();
        $ticket = new Ticket(array(
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'slug' => $slug,
        ));
        $ticket->save();
        // send mail
        $data = array(
            'ticket' => $slug,
        );

        Mail::send('emails.ticket', $data, function ($message) {
            $message->from('chenweiyeu@gmail.com', 'Learning Laravel');

            $message->to('chenweiyeu@gmail.com')->subject('There is a new ticket!');
        });

        return redirect('/contact')->with('status', 'Your ticket has been created! Its unique id is: ' . $slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $ticket = Ticket::whereSlug($slug)->firstOrFail();
        $comments = $ticket->comments()->get();
        return view('tickets.show', compact('ticket', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $ticket = Ticket::whereSlug($slug)->firstOrFail();
        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $slug
     * @return \Illuminate\Http\Response
     */
    public function update(TicketFormRequest $request, $slug)
    {
        $ticket = Ticket::whereSlug($slug)->firstOrFail();
        $ticket->title = $request->get('title');
        $ticket->content = $request->get('content');
        if ($request->get('status') != null) {
            $ticket->status = 0;
        } else {
            $ticket->status = 1;
        }
        $ticket->save();
        return redirect(action('TicketsController@edit', $ticket->slug))->with('status', 'The ticket ' . $slug . ' has been updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $ticket = Ticket::whereSlug($slug)->firstOrFail();
        $ticket->delete();
        return redirect('/tickets')->with('status', 'The ticket ' . $slug . ' has been deleted!');
    }
}
