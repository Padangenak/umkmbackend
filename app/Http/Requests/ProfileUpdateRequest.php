<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\User_attachment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Traits\ImageTrait;

class ProfileUpdateRequest extends FormRequest
{
    use ImageTrait;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'phoneNumber'=>"numeric"
        ];
    }
    public function change(){
        $user = User::find(Auth::user()->id);
        // dd($user);
        User::find(Auth::user()->id)->update([
            'name'=>$this->name != null ? $this->name : $user->name,
            'username'=>$this->username != null ? $this->username : $user->username,
            'store'=>$this->store != null ? $this->store : $user->store,
            'address'=>$this->address != null ? $this->address : $user->address,
            'phone_number'=>$this->phoneNumber != null ? $this->phoneNumber : $user->phone_number,
        ]);
        if($this->password != null){
            User::find(Auth::user()->id)->update([
                'password'=>$this->password
            ]);
        }
        if ($this->attachment != null) {
            $image = $this->resize($this->attachment);
            $explode = explode('.', $image->basename);

            $attachment = User_attachment::where('user_id', Auth::user()->id)->update([
                'path'=>'/images/',
                'type'=>$explode[1],
                'filename'=>$image->basename,
                'user_id'=>Auth::user()->id,
            ]);
            
        }

        return User::all();
    }
}
