<?php

namespace App\UseCases\Vacancies;

use App\Entity\Vacancy;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class VacancyService
{
  public function create($userId, Request $request): Vacancy
  {
    $user = User::findOrFail($userId);
    $count = $user->vacancies()->where('status','active')->count();
    $status = $count ? Vacancy::STATUS_ACTIVE : Vacancy::STATUS_MODERATION;
    $vacancy = Vacancy::make([
      'title' => $request['title'],
      'content' => $request['content'],
      'status' => $status,
    ]);
    /** @var Vacancy $vacancy */

    $vacancy->user()->associate($user);
    $vacancy->saveOrFail();
    return $vacancy;

  }

  public function edit($id, Request $request): void
  {
    $vacancy = $this->getVacancy($id);
    $vacancy->update($request->only([
      'title',
      'content',
    ]));
  }

  public function sendToModeration($id): void
  {
    $vacancy = $this->getVacancy($id);
    $vacancy->sendToModeration();
  }

  public function moderate($id): void
  {
    $vacancy = $this->getVacancy($id);
    $vacancy->moderate(Carbon::now());
    event(new ModerationPassed($vacancy));
  }

  public function remove($id): void
  {
    $vacancy = $this->getVacancy($id);
    $vacancy->delete();
  }

  private function getVacancy($id): Vacancy
  {
    return Vacancy::findOrFail($id);
  }
}
