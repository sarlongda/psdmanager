<?php


namespace App\Http\Controllers;


use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Card;
use Illuminate\Support\Facades\Log;


class ArticleController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cards = Card::all();
        return view('articles.index', compact('cards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->title == '') return back();

        $allCategories = Category::pluck('title','id')->all();

        return view('articles.create-card', compact('allCategories', 'request'));
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'article_id' => 'required|unique:cards'
        ]);
        $input = $request->all();

        Card::create($input);
        return redirect('/articles');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $allCategories = Category::pluck('title','id')->all();

        $card = Card::findOrFail($id);

        $psd_exist = file_exists('c:/xampp/htdocs/psdmanager/public/PSD_Manager/Articles/Template1/'.$card->article_id.'/'.$card->article_id.'_tmp_1.psd') & file_exists('c:/xampp/htdocs/psdmanager/public/PSD_Manager/Articles/Template1/'.$card->article_id.'/'.$card->article_id.'_tmp_2.psd');
        $prev_exist = file_exists('c:/xampp/htdocs/psdmanager/public/PSD_Manager/Articles/Template1/'.$card->article_id.'/'.$card->article_id.'_prev_1.png') & file_exists('c:/xampp/htdocs/psdmanager/public/PSD_Manager/Articles/Template1/'.$card->article_id.'/'.$card->article_id.'_prev_2.png');

        return view('articles/edit-card', compact('allCategories', 'card', 'psd_exist', 'prev_exist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $card = Card::findOrFail($id);
        if($request->update == 'update') {
            $this->validate($request, [
                'title' => 'required',
                'article_id' => 'required|unique:cards',
            ]);
            $card->update($request->all());
            return back()->with('success', 'Category updated successfully.');
        }
        else {
            $age = $card->age;
            $plz = $card->plz;

            //Generate Date of Birth
            $dob_day = rand(1, 28);
            if($dob_day<10) $dob_day = '0'.$dob_day;
            $dob_month = rand(1,12);
            if($dob_month<10) $dob_month = '0'.$dob_month;
            $dob_year = date("Y") - $age;
            $dob = $dob_day . '.' . $dob_month . '.' . $dob_year;

            //Generate Date of Expire
            $doe_day = rand(1, 28);
            if($doe_day<10) $doe_day = '0'.$doe_day;
            $doe_month = rand(1,12);
            if($doe_month<10) $doe_month = '0'.$doe_month;
            $doe_year = date("Y") + ($age>=24 ? rand(2, 8) : rand(2, 3));
            $doe = $doe_day . '.' . $doe_month . '.' . $doe_year;

            //Generate ID
            $aic_list = array_map('str_getcsv', file('aic.csv'));
            array_walk($aic_list, function(&$a) use ($aic_list) {
                $a = array_combine($aic_list[0], $a);
            });
            array_shift($aic_list);
            if(strlen($plz) == 4 && substr($plz, 0, 1) == 'L') {
                $aic = $plz;
                for ($i = 0; $i <= sizeof($aic_list)-1; $i++) {
                    $authority_pos = strpos($aic_list[$i]['AIC'], $aic);
                    if (is_int($authority_pos) == TRUE) {
                        $authority = $aic_list[$i]['AUTHORITY'];
                        break;
                    }
                }
            } else if (strlen($plz) == 5 && ctype_digit($plz) == TRUE) {
                for ($i = 0; $i <= sizeof($aic_list)-1; $i++) {
                    $diff = abs($aic_list[$i]['ZIP'] - $plz);
                    if($i == 0) {
                        $min = $diff;
                        $idx_min = $i;
                    }
                    else if ($diff < $min) {
                        $min = $diff;
                        $idx_min = $i;
                    }
                }
                $aic = $aic_list[$idx_min]['AIC'];
            } else if ($plz != "") {
                $error = TRUE;
                echo "<p id='error'>".htmlspecialchars("Error! Enter valid ZIP or Authority Ident Code")."</p>";
            }
            $serial = $this->generateRandomString();
            $id = $aic.$serial;
//            if ($age >= 24)
//                $str_date = $doe_day + 1 . '.' . $doe_month . '.' . $doe_year - 10;
//            else
//                $str_date = $doe_day + 1 . '.' . $doe_month . '.' . $doe_year - 6;
//            $section_one = $id;
//            $section_one = $section_one.checknumber($section_one);
//            $section_two = $dob_year.$dob_month.$dob_day;
//            $section_two = $section_two.checknumber($section_two);
//            $section_three = $doe_year.$doe_month.$doe_day;
//            $section_three = $section_three.checknumber($section_three);
//            $section_four = $section_one.$section_two.$section_three;
            $addr = "f:/htdocs/psdmanager/public/PSD_Manager/PSD_TEST.exe ".$card->article_id ." " . $dob." ".$doe." ".$id;
            Log::debug($addr);
            exec($addr, $output);
            return back()->with('success', 'Category updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $card = Card::find($id);

        $card->delete();

        return back()->with('success', 'Article deleted successfully.');
    }

    public function preview_front($id)
    {

    }

    public function preview_back($id)
    {

    }

    private function generateRandomString($length = 5) {
        $characters = 'CDFGHJKLMNPRTVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}