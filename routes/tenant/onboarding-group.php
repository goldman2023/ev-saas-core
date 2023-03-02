<?php

use App\Http\Controllers\OnboardingController;

Route::get('/welcome', [OnboardingController::class, 'step2'])->name('onboarding.step1')->middleware(['auth']);
Route::get('/welcome/step2', [OnboardingController::class, 'step2'])->name('onboarding.step2')->middleware(['auth']);
Route::post('/welcome/profile/store', [OnboardingController::class, 'profile_store'])->name('onboarding.profile.store')->middleware(['auth']);
Route::get('/welcome/work-and-education', [OnboardingController::class, 'work_and_education'])->name('onboarding.work-and-education')->middleware(['auth']);
Route::get('/welcome/step3', [OnboardingController::class, 'step3'])->name('onboarding.step3')->middleware(['auth']);
Route::get('/welcome/step4', [OnboardingController::class, 'step4'])->name('onboarding.step4')->middleware(['auth']);
Route::get('/welcome/verification', [OnboardingController::class, 'verification'])->name('onboarding.verification')->middleware(['auth']);

