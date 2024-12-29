<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        $users = User::all();
        return view('welcome', compact(['events','users']));
    }

    public function store(Request $request)
    {

        $event = Event::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'rating' => $request->state,
            'start' => $request->start,
            'end' => $request->end,
        ]);
 

        /* // save ile kayıt örneği      
        $event = new Event();
        $event->user_id = $request->user_id;
        $event->title = $request->title;
        $event->description = $request->description;
        $event->rating = $request->state;
        $event->start = $request->start;
        $event->end = $request->end;
        $event->save();  
        */


        /*   //Core sql kullanarak kayıt işlemi örneği 
        $event = DB::table('events')->insert([
        'user_id' => $request->user_id,
        'title' => $request->title,
        'description' => $request->description,
        'rating' => $request->state,
        'start' => Carbon::parse($request->start)->format('Y-m-d H:i:s'),
        'end' => Carbon::parse($request->end)->format('Y-m-d H:i:s'),
        'created_at' => now(),
        'updated_at' => now(),
        ]); */

        if ($event) {
            return response()->json(['success' => true, 'message' => 'İşlem başarılı', 'event' => $event], 201);
        }
        return response()->json(['success' => false, 'message' => 'İşlem başarısız'], 404);
    }

    public function update(Request $request)
    {
        $event = Event::findOrFail($request->id);

        $payload = [
            'user_id' => $request->user_id ? $request->user_id : $event->id,
            'title' => $request->title ? $request->title : $event->title,
            'description' => $request->description ? $request->description : $event->description,
            'rating' => $request->rating ? $request->rating : $event->rating,
            'start' => $request->start ? $request->start : $event->start,
            'end' => $request->end ? $request->end : $event->end,
        ];


        /* //Örnek update kodu
        $event = Event::find($id);
        if ($event) {
            $event->user_id = isset($payload['user_id']) ? $payload['user_id'] : $event->user_id;
            $event->title = isset($payload['title']) ? $payload['title'] : $event->title;
            $event->description = isset($payload['description']) ? $payload['description'] : $event->description;
            $event->rating = isset($payload['rating']) ? $payload['rating'] : $event->rating;
            $event->start = isset($payload['start']) ? $payload['start'] : $event->start;
            $event->end = isset($payload['end']) ? $payload['end'] : $event->end;
            $event->update();
        }
        */

        /* //Core sql ile örnek update işlemi
        DB::table('events')
            ->where('id', $id)
            ->update([
                'user_id' => isset($payload['user_id']) ? $payload['user_id'] : DB::raw('user_id'),
                'title' => isset($payload['title']) ? $payload['title'] : DB::raw('title'),
                'description' => isset($payload['description']) ? $payload['description'] : DB::raw('description'),
                'rating' => isset($payload['rating']) ? $payload['rating'] : DB::raw('rating'),
                'start' => isset($payload['start']) ? Carbon::parse($payload['start'])->format('Y-m-d H:i:s') : DB::raw('start'),
                'end' => isset($payload['end']) ? Carbon::parse($payload['end'])->format('Y-m-d H:i:s') : DB::raw('end'),
                'updated_at' => now(),
        ]);
        */

        if ($event->update($payload)) {
            return response()->json(['success' => true, 'message' => 'İşlem başarılı'], 201);
        }
        return response()->json(['success' => false, 'message' => 'İşlem başarısız'], 404);
    }

    public function destroy(Request $request)
    {
        $event = Event::findOrFail($request->id);

        /* // örnek olarak oluşturulmuş alternatif silme işlemi         
        $deleted = Event::where('id', $request->id)->delete(); 
        */

        /* // Core sql ile alternatif kayıt silme işlemi
        $deleted = DB::table('events')->where('id', $request->id)->delete(); 
        */

        if ($event->delete()) {
            return response()->json(['success' => true, 'message' => 'İşlem başarılı'], 201);
        }
        return response()->json(['success' => false, 'message' => 'İşlem başarısız'], 404);
    }


    public function pdfConvert(Request $request)
    {

        $events = Event::with('user')->get();

        $pdf = Pdf::loadView('pdf', ['events' => $events]);
        return $pdf->download('document.pdf');

    }
    
}
