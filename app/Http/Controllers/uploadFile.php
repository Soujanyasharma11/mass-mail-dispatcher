<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailInfo;
use App\Models\User;
use App\Mail\sendBulkMail;
use Illuminate\Support\Facades\Mail;
use App\Jobs\VerifyEmail;
use Illuminate\Support\Facades\DB;
class uploadFile extends Controller
{
    public function store(Request $request)
    {
        // $request->validate([
        //     'file' => 'required|mimes:csv,txt',
        // ]);
        $file = $request->file('csv_file');
        // dd($file);
        $file_name = $file->getClientOriginalName();
        // store in files
      
        $file->move(public_path('files').'/', $file_name);
        $file_path = public_path('files/').$file_name;
        $file = fopen($file_path, 'r');
        $emails = [];
        while(($line = fgetcsv($file)) !== false){
            $emails[] = $line[0];
        }
        fclose($file);
        // dd($emails);
       // upload to EmailInfo
        foreach($emails as $email){
            $emailInfo = new EmailInfo;
            $emailInfo->email = $email;
            $emailInfo->save();
        }
    
            DB::table('email_infos')->where('id', '=', 1)->delete();
           

        
        return redirect()->route('admin')->with('success', 'File Uploaded successfully');   
    }

    public function sendEmail(Request $request){
      

        $emails = User::all()->pluck('email')->toArray();
        $emailContent=$request->email;
        
        $path=public_path('attachment');

            $attachment= $request->file('attachment');
            
            // dd($attachment);
            // $fileName=$attachment->getClientOriginalExtension();
            // dd($fileName);   
            $originalName=$attachment->getClientOriginalName();

            // dd($originalName);
            $attachment->move($path,$originalName);
            $pathToFile=$path.'/'.$originalName;
            // dd($pathToFile);
       
        
        
        


       
        // validate email
        $valid_emails = [];
        foreach($emails as $email){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $valid_emails[] = $email;
            }
        }
        // dd($valid_emails);
        // send email
        
        // if($originalName){
        //     foreach($valid_emails as $email){
        //         VerifyEmail::dispatch($email, $emailContent, $pathToFile)->onQueue('emails');
        //     }
        // }else{
        //     foreach($valid_emails as $email){
        //         VerifyEmail::dispatch($email, $emailContent)->onQueue('emails');
        //     }
        // }
        
        foreach($valid_emails as $email){
            $this->dispatch(new VerifyEmail($email,
            $emailContent,
            $pathToFile
            ));
        }
        

        // Mail::to($valid_emails)->send(new sendBulk(
        //     $emails,
         //   $emailContent
        // ));
  
        
      


        // dd($emails);
        // Mail::to($emails)->send(new sendBulk($emails/*$emailContent*/));
        // foreach($emails as $email){
        //     VerifyEmail::dispatch($email,$emailContent);
        // }
        session()->flash('success','Email Sent Successfully');
        return redirect()->route('admin');

    }
    public function seeEmail(){
        $emails=EmailInfo::orderBy('id','desc')->get();
        return view('view-email',compact('emails'));
    }



}
