<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;
use Random\RandomException;

class AdminController extends Controller
{
  /**
   * @desc Destroy an authenticated session.
   * @param Request $request
   * @return RedirectResponse
   */
  public function adminLogout(Request $request): RedirectResponse
  {
    Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/login');
  }

  /**
   * @desc login with TwoFactor Authentication (2FA) using a verification code
   * @param Request $request
   * @return RedirectResponse
   * @throws RandomException
   */
  public function adminLogin(Request $request)
  {
    $credentials = $request->only('email', 'password');

    // Si user connecté
    if(Auth::attempt($credentials)) {
      $user = Auth::user();

      $verificationCode = random_int(100000, 999999);

      session([
        'verification_code' => $verificationCode,
        'user_id' => $user->id,
      ]);

      // envoi du code à l'utilisateur connecté
      Mail::to($user->email)->send(new VerificationCodeMail($verificationCode));

      Auth::logout();

      // Redirect vers le formulaire de vérification du code
      return redirect()->route('custom.verification.form')
                       ->with('success', 'Verification code has been sent to your email.');
    }

    return redirect()->back()->withErrors(['email' => 'Invalid credentials provided.']);
  }

  /**
   * @desc Formulaire de vérification du code Two-Factor Authentication (2FA)
   * @return Factory|View|\Illuminate\View\View
   */
  public function showVerification()
  {
    return view('auth.verify');
  }

  /**
   * @desc Vérification du code 2FA Authentification
   * @param Request $request
   * @return RedirectResponse
   */
  public function verificationVerify(Request $request)
  {
    $request->validate(['code' => 'required|numeric']);

    if ($request->code == session('verification_code')) {
      Auth::loginUsingId(session('user_id'));

      session()->forget(['verification_code', 'user_id']);

      return redirect()->intended('/dashboard');
    }

    return back()->withErrors(['code' => 'Invalid verification code.']);
  }

  /**
   * @desc Affiche la vue Profile d'un utilisateur connecté
   * @return Factory|View|\Illuminate\View\View
   */
  public function adminProfile()
  {
    $id = Auth::user()->id;
    $profileData = User::find($id);
    return view('admin.admin_profile', compact('profileData'));
  }

  /**
   * @param Request $request
   * @return RedirectResponse
   */
  public function profileStore(Request $request)
  {
    $id = Auth::user()->id;
    $data = User::find($id);

    $data->name = $request->name;
    $data->email = $request->email;
    $data->phone = $request->phone;
    $data->address = $request->address;

    $oldPhotoPath = $data->photo;
    if ($request->hasFile('photo')) {
      $file = $request->file('photo');
      $filename = time() . '.' . $file->getClientOriginalExtension();
      $file->move(public_path('upload/user_images'), $filename);
      $data->photo = $filename;

      if ($oldPhotoPath && $oldPhotoPath !== $filename) {
        $this->deleteOldImage($oldPhotoPath);
      }
    }

    $data->save();

    return redirect()->back();
  }

  /**
   * @desc Supprime l'ancienne image du dossier de destination
   * @param string $oldPhotoPath
   * @return void
   */
  private function deleteOldImage(string $oldPhotoPath): void
  {
    $fullPath = public_path('upload/user_images/') . $oldPhotoPath;
    if (file_exists($fullPath)) {
      unlink($fullPath);
    }
  }

}
