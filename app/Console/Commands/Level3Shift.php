<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Level3Shift extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:level3shift';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data =  Transition::where(['tolevel'=>3,'is_transfered'=>0])->where('created_at', '>', Carbon::now()->subMinutes(200)->toDateTimeString())->get();
        foreach ($data as $key => $value) {
            $tolevel=4;
            $depid=$value->departmentid;
            $depusers=User::where(['department'=>$depid,'role'=>$tolevel])->first();
            $newtransition=Transition::create(['complaintid'=>$value->complaintid,'fromlevel'=>$value->tolevel,'tolevel'=>$tolevel,'fromuser'=>$value->touser,'touser'=>$depusers->id,'departmentid'=>$depid]);
            $frommailname=$newtransition->fromuserrelation->name;
            $frommailemail=$newtransition->fromuserrelation->email;
            $tomailname=$newtransition->touserrelation->name;
            $tomailemail=$newtransition->touserrelation->email;
            $value->update(['is_transfered'=>1]);
            Mail::to('twinkle.taneja@neologicx.com')->send(new SendTestMail($frommailname,$frommailemail,$tomailname,$tomailemail));
        }
    }
}
