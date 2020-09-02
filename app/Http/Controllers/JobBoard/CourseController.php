<?php

namespace App\Http\Controllers\JobBoard;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\JobBoard\Professional;
use App\Models\JobBoard\Course;

class CourseController extends Controller
{
    // Muestra lista de cursos existentes//
    function index(Request $request)
    {
        try {
            $professional = Professional::where('id', $request->user_id)->first();
            if ($professional) {
                $courses = Course::where('professional_id', $professional->id)
                    ->orderby($request->field, $request->order)
                    ->paginate($request->limit);
                return response()->json([
                    'pagination' => [
                        'total' => $courses->total(),
                        'current_page' => $courses->currentPage(),
                        'per_page' => $courses->perPage(),
                        'last_page' => $courses->lastPage(),
                        'from' => $courses->firstItem(),
                        'to' => $courses->lastItem()
                    ], 'courses' => $courses], 200);
            } else {
                return response()->json([
                    'pagination' => [
                        'total' => 0,
                        'current_page' => 1,
                        'per_page' => $request->limit,
                        'last_page' => 1,
                        'from' => null,
                        'to' => null
                    ], 'courses' => null], 404);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json($e, 405);
        } catch (NotFoundHttpException  $e) {
            return response()->json($e, 405);
        } catch (QueryException $e) {
            return response()->json($e, 400);
        } catch (Exception $e) {
            return response()->json($e, 500);
        } catch (Error $e) {
            return response()->json($e, 500);
        } catch (ErrorException $e) {
            return response()->json($e, 500);
        }
    }
 // Muestra el dato especifico del Curso//
    function show($id)
    {
        try {
            $course = Course::findOrFail($id);
            return response()->json(['course' => $course], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json($e, 405);
        } catch (NotFoundHttpException  $e) {
            return response()->json($e, 405);
        } catch (QueryException $e) {
            return response()->json($e, 400);
        } catch (Exception $e) {
            return response()->json($e, 500);
        } catch (Error $e) {
            return response()->json($e, 500);
        }
    }
//Almacena los  Datos creado del curso envia//
    function store(Request $request)
    {
        try {
            $data = $request->json()->all();
            $dataUser = $data['user'];
            $dataCourse = $data['course'];
            $professional = Professional::where('user_id', $dataUser['id'])->first();
            if ($professional) {
                $response = $professional->courses()->create([
                    'event_name' => strtoupper($dataCourse ['event_name']),
                    'start_date' => $dataCourse ['start_date'],
                    'finish_date' => $dataCourse ['finish_date'],
                    'hours' => $dataCourse ['hours'],
                ]);
                return response()->json($response, 201);
            } else {
                return response()->json(null, 404);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json($e, 405);
        } catch (NotFoundHttpException  $e) {
            return response()->json($e, 405);
        } catch (QueryException $e) {
            return response()->json($e, 400);
        } catch (Exception $e) {
            return response()->json($e, 500);
        } catch (Error $e) {
            return response()->json($e, 500);
        }
    }
  //Actualiza los datos del curso creado//
    function update(Request $request)
    {
        try {
            $data = $request->json()->all();
            $dataCourse = $data['course'];
            $course = Course::findOrFail($dataCourse ['id'])->update([
                'event_name' => $dataCourse ['event_name'],
                'start_date' => $dataCourse ['start_date'],
                'finish_date' => $dataCourse ['finish_date'],
                'hours' => $dataCourse ['hours'],
            ]);
            return response()->json($course, 201);
        } catch (ModelNotFoundException $e) {
            return response()->json($e, 405);
        } catch (NotFoundHttpException  $e) {
            return response()->json($e, 405);
        } catch (QueryException $e) {
            return response()->json($e, 400);
        } catch (Exception $e) {
            return response()->json($e, 500);
        } catch (Error $e) {
            return response()->json($e, 500);
        }
    }
//Elimina los datos del curso//
    function destroy(Request $request)
    {
        try {
            $course = Course::findOrFail($request->id)->delete();
            return response()->json($course, 201);
        } catch (ModelNotFoundException $e) {
            return response()->json($e, 405);
        } catch (NotFoundHttpException  $e) {
            return response()->json($e, 405);
        } catch (QueryException $e) {
            return response()->json($e, 400);
        } catch (Exception $e) {
            return response()->json($e, 500);
        } catch (Error $e) {
            return response()->json($e, 500);
        }
    }
}
