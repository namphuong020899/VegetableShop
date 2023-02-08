<?php

namespace App\Http\Controllers\BackEnd;

use App\Coupon;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            return datatables()->of(Coupon::orderBy('coupon_id','desc')->get())
                ->addColumn('action', function($data){
                    $button = '<button type="button" data-id="'.$data->coupon_id .'"  class="btn btn-outline-primary editsample"><i class="fa fa-edit"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" class="btn btn-outline-danger delete" data-id="'.$data->coupon_id .'"><i class="fa fa-trash"></i>
                            </button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $title = 'Coupon';
        return view('BackEnd.Coupon.list', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(request()->ajax()){
            $coupon = new Coupon();
            $coupon->coupon_code = $request->coupon_code;
            $coupon->coupon_qty = $request->coupon_qty;
            if($request->coupon_date_start > $request->coupon_date_end){
                $coupon->coupon_date_start = Carbon::now()->format('d/m/y');
                $coupon->coupon_date_end = Carbon::tomorrow()->format('d/m/y');
            }else{
                $coupon->coupon_date_start = $request->coupon_date_start;
                $coupon->coupon_date_end = $request->coupon_date_end;
            }
            $coupon->coupon_condition = $request->coupon_condition;
            $coupon->coupon_sale_number = $request->coupon_sale_number;
            $coupon->coupon_status = $request->coupon_status;
            $coupon->save();

            return response()->json([
                'status'=>200,
                'message'=>'Add Successfully'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sample = Coupon::findOrfail($id);
        if($sample){
            return response()->json([
                'status'=>200,
                'data'=>$sample
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Data Not Found'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sample = Coupon::findOrfail($id);
        if($sample){
            if($sample->coupon_status == 1){
                $sample->coupon_status = 2;
            }else{
                $sample->coupon_status = 1;
            }
            $sample->save();
            return response()->json([
                'status'=>200
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Data Not Found'
            ]);
        }
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
        if(request()->ajax()){
            $coupon = Coupon::findOrfail($id);
            if($coupon){
                $coupon->coupon_code = $request->coupon_code;
                $coupon->coupon_qty = $request->coupon_qty;
                if($request->coupon_date_start > $request->coupon_date_end){
                    $coupon->coupon_date_start = Carbon::now()->format('d/m/y');
                    $coupon->coupon_date_end = Carbon::tomorrow()->format('d/m/y');
                }else{
                    $coupon->coupon_date_start = $request->coupon_date_start;
                    $coupon->coupon_date_end = $request->coupon_date_end;
                }
                $coupon->coupon_condition = $request->coupon_condition;
                $coupon->coupon_sale_number = $request->coupon_sale_number;
                $coupon->coupon_status = $request->coupon_status;
                $coupon->save();

                return response()->json([
                    'status'=>200,
                    'message'=>'Add Successfully'
                ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Data Not Found'
                ]);
            }
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
        $sample = Coupon::findOrfail($id);
        if($sample){
            $sample->delete();

            return response()->json([
                'status'=>200,
                'message'=>'Delete Successfully'
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Data Not Found'
            ]);
        }
    }
}
