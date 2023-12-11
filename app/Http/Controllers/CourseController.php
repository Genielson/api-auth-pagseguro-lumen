<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

/** @package App\Http\Controllers */
class CourseController extends Controller
{

    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){}
    /**
     * @param Request $request
     * @return array
     * @throws ValidationException
     */
    public function isRegisterValid(Request $request)
    {

        return  $this->validate(
            $request,
            [
                'name' => 'required',
                'description' => 'required',
                'amount_hour' => 'required',
                'amount_module' => 'required',
                'user_id' => 'required'
            ]
        );
    }

    public function index(){
        $courses = Course::all();
        if(count($courses) > 0){
            return response()->json([$courses,200]);
        }else{
            return response()->json(["Não encontramos nenhum curso", 404]);
        }
    }

    public function show($id){
        $course = Course::findOrFail($id);
        if(count($course) > 0){
            return response()->json([$course,200]);
        }else{
            return response()->json(["Não encontramos nenhum curso", 404]);
        }
    }

    /**
     * @param Request $request
     * @return array
     * @throws ValidationException
     */

    /**
     * @param Request $request
     * @return App\Traits\Iluminate\Http\Response|void
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        if ($this->isRegisterValid($request)) {

            if(Course::create($request)){
                return response()->json([' Curso criado com sucesso ', 201]);
            }else{

            }

        }else{
            return response()->json(['Algum parametro não foi enviado corretamente',404]);
        }
    }

    /**
     * @param Request $request
     * @return App\Traits\Iluminate\Http\Response|App\Traits\Iluminate\Http\JsonResponse|void
     * @throws ValidationException
     */
    public function register(Request $request)
    {
        if ($this->isRegisterValid($request)) {
            try {
                $user = new User();
                $user->password = $request->password;
                $user->email = $request->email;
                $user->name = $request->name;
                $user->save();
                return $this->successResponse($user);
            } catch (\Exception $e) {
                return $this->errorResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

}
