<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Vacancy;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
    $query = Vacancy::orderByDesc('updated_at');

    $vacancies = $query->paginate(20);

    $statuses = Vacancy::statusesList();

    $roles = User::rolesList();

    return view('admin.vacancies.index', compact('vacancies', 'statuses', 'roles'));
  }

  public function moderate(Vacancy $vacancy)
  {
    try {
      $this->service->moderate($vacancy->id);
    } catch (\DomainException $e) {
      return back()->with('error', $e->getMessage());
    }

    return redirect()->route('adverts.show', $vacancy);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
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
    return redirect()->route('admin.vacancies.index');
  }

  private function checkAccess(Vacancy $vacancy): void
  {
    if (!Gate::allows('manage-own-vacancy', $vacancy) and !Gate::allows('manage-vacancies', $vacancy) ) {
      abort(403);
    }
  }
}
