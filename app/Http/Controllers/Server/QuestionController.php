<?php

namespace App\Http\Controllers\Server;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Repositories\QuestionRepository;

class QuestionController extends Controller
{
    /**
     *  问题仓库
     */
    protected $question;

    /**
     *  初始化参数
     */
    public function __construct(QuestionRepository $question)
    {
        $this->middleware('auth')->except(['index','show']);
        $this->question = $question;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = $this->question->GetQuestionFeed();

        return view('question.index',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('question.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
        $normalizeTopic = $this->question->normalizeTopic($request->get('topic'));

        $data = [
            'title' => $request->get('title'),
            'body' => ($request->get('body')),
            'user_id' => Auth::user()->id
        ];

        $question = $this->question->CreateQuestion($data);

        $question->topic()->attach($normalizeTopic);

        return redirect()->route('question.show',[$question->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = $this->question->GetQuestionWithTopicById($id);
        //dump($question);
        return view('question.show',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = $this->question->GetOneQuestionWithTopicById($id);

        // 检查当前用户是否为问题作者
        if(Auth::user()->owns($question)){
            return view('question.edit',compact('question'));
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionRequest $request, $id)
    {
        $question = $this->question->GetOneQuestionWithTopicById($id);
        $normalizeTopic = $this->question->normalizeTopic($request->get('topic'));

        $question->update([
            'title' => $request->get('title'),
            'body' => $request->get('body'),
        ]);

        $question->topic()->sync($normalizeTopic);

        return redirect()->route('question.show',[$question->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = $this->question->GetOneQuestionWithTopicById($id);

        if(Auth::user()->owns($question)){
            $question->delete();
            // 中间表删除 ??

            return redirect('/');
        }

        return back();
    }

}
