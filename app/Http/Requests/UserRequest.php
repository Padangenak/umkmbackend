<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use App\Models\User_attachment;
use App\Traits\ImageTrait;

class UserRequest extends FormRequest
{
    use ImageTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required',
            'username'=>'required|unique:users|min:6',
            'password'=>'required|min:6',
            'address'=>'required',
            'phoneNumber'=>'required|numeric|digits_between:6,14',
            'role'=>'required',
            'store'=>'required|min:6',
            'attachment'=>'required',
        ];
    }
    public function add(){
        // dd($this->validated());
        $image = $this->resize($this->validated()['attachment']);
        $explode = explode('.', $image->basename);

        $user = User::create([
            'name'=>$this->validated()['name'],
            'username'=>$this->validated()['username'],
            'password'=>$this->validated()['password'],
            'address'=>$this->validated()['address']['name'],
            'phone_number'=>$this->validated()['phoneNumber'],
            'role_id'=>$this->validated()['role']['id'],
            'store'=>$this->validated()['store'],
            'active'=>'On',
        ]);
        $attachment = User_attachment::create([
            'path'=>'/images/',
            'type'=>$explode[1],
            'filename'=>$image->basename,
            'user_id'=>$user->id,
        ]);

        return $user;
    }
}
