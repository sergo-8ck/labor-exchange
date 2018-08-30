<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\Vacancy;
use App\UseCases\Vacancies\VacancyService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class VacancyController extends Controller
{

  private $service;

  public function __construct(VacancyService $service)
  {
    $this->service = $service;
  }


  public function index()
  {
    $vacancies = Vacancy::forUser(Auth::user())->orderByDesc('id')->paginate(10);

    return view('cabinet.vacancies.index', compact('vacancies'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('cabinet.vacancies.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    try {
      $vacancy = $this->service->create(Auth::id(), $request);
    } catch (\DomainException $e) {
      return back()->with('error', $e->getMessage());
    }

    return redirect()->route('cabinet.vacancies.show', $vacancy->id);
  }

  /**
   * Display the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $vacancy = Vacancy::query()->where('id', $id)->first();

    return view('cabinet.vacancies.show', compact('vacancy'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $vacancy = Vacancy::query()->where('id', $id)->first();

    return view('cabinet.vacancies.edit', compact('vacancy'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Vacancy $vacancy)
  {
    $vacancy->update($request->all());
    return redirect()->route('cabinet.vacancies.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Vacancy $vacancy)
  {
    $this->checkAccess($vacancy);
    try {
      $this->service->remove($vacancy->id);
    } catch (\DomainException $e) {
      return back()->with('error', $e->getMessage());
    }
    return redirect()->route('cabinet.vacancies.index');
  }

  private function checkAccess(Vacancy $vacancy): void
  {
    if (!Gate::allows('manage-own-vacancy', $vacancy)) {
      abort(403);
    }
  }
}
