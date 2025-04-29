ParentProblems::all()
ParentProblems::where('staff_id', auth()->user()->id)->orWhere('staff_id', null)->get()

ParentProblems::where('problem_status' , 'عاجل')->get()
ParentProblems::where('problem_status' , 'عاجل')->where('staff_id', auth()->user()->id)->orWhere('staff_id', null)->get()

ParentProblems::where('problem_status' , 'جاري حلها')->get()
ParentProblems::where('problem_status' , 'جاري حلها')->where('staff_id', auth()->user()->id)->orWhere('staff_id', null)->get()

ParentProblems::where('problem_status' , 'تم الإلغاء')->get()
ParentProblems::where('problem_status' , 'تم الإلغاء')->where('staff_id', auth()->user()->id)->orWhere('staff_id', null)->get()

ParentProblems::where('deadline', '<', Carbon::now())->get()
ParentProblems::where('deadline', '<', Carbon::now())->where('staff_id', auth()->user()->id)->orWhere('staff_id', null)->get()

ParentProblems::where('problem_status' , 'تم حلها')->get()
ParentProblems::where('staff_id', auth()->user()->id)->orWhere('staff_id', null)->get()