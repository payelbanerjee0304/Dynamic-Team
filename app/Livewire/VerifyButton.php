<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Member;

class VerifyButton extends Component
{


    public $isVerified = false;

    public function verifyUser($userId)
    {
        // dump($userId);

        $user = Member::where("_id", $userId)->first();

        $user->isVerified = "Yes";

        $user->save();

        $this->isVerified = true;

        // $this->dispatchBrowserEvent('refresh');
    }

    public function render(Request $request)
    {
        $fullUrl = $request->fullUrl();
        $segments = explode('/', $fullUrl);
        $userId = end($segments);

        $user = Member::where("_id", $userId)->first();

        $verified = false;
        if (isset($user->isVerified) && $user->isVerified == "Yes") {
            $verified = true;
        }

        $this->isVerified = $verified;
        return view('livewire.verify-button', compact('userId'));
    }
}
