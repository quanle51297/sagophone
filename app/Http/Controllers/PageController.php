<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\NhomSanPham;

use App\SanPham;

use App\HangDT;

use App\DanhSachBanner;

use App\Banner;

use App\Mau;

use App\SoLuongMauSP;

use DB;

class PageController extends Controller
{

	function __construct()
	{
		$nhomsanpham = NhomSanPham::all();
		$hangdt = HangDT::all();
		$sanphammoi = DanhSachBanner::where('id_banner','3')->join('tbsanpham','id_sanpham','id')->join('tbsoluongmausp','tbsanpham.id','tbsoluongmausp.id_sanpham')->get();
		$sanphambanchay = DanhSachBanner::where('id_banner','4')->join('tbsanpham','id_sanpham','id')->join('tbsoluongmausp','tbsanpham.id','tbsoluongmausp.id_sanpham')->get();
		$sanphamhotdeals = DanhSachBanner::where('id_banner','2')->join('tbsanpham','id_sanpham','id')->join('tbsoluongmausp','tbsanpham.id','tbsoluongmausp.id_sanpham')->get();
		$sanphambanchay1 = DanhSachBanner::where('id_banner','4')->take(3)
		->join('tbsanpham','id_sanpham','id')->join('tbsoluongmausp','tbsanpham.id','tbsoluongmausp.id_sanpham')
		->get();
		$sanphambanchay2 = DanhSachBanner::where('id_banner','4')->skip(3)->take(3)
		->join('tbsanpham','id_sanpham','id')->join('tbsoluongmausp','tbsanpham.id','tbsoluongmausp.id_sanpham')
		->get();
		$sanphammoi1 = DanhSachBanner::where('id_banner','3')->take(3)
		->join('tbsanpham','id_sanpham','id')->join('tbsoluongmausp','tbsanpham.id','tbsoluongmausp.id_sanpham')
		->get();
		$sanphammoi2 = DanhSachBanner::where('id_banner','3')->skip(3)->take(3)
		->join('tbsanpham','id_sanpham','id')->join('tbsoluongmausp','tbsanpham.id','tbsoluongmausp.id_sanpham')
		->get();
		$sanphamhotdeals1 = DanhSachBanner::where('id_banner','2')
		->join('tbsanpham','id_sanpham','id')->join('tbsoluongmausp','tbsanpham.id','tbsoluongmausp.id_sanpham')
		->take(3)->get();
		$sanphamhotdeals2 = DanhSachBanner::where('id_banner','2')	
		->join('tbsanpham','id_sanpham','id')->join('tbsoluongmausp','tbsanpham.id','tbsoluongmausp.id_sanpham')
		->skip(3)->take(3)->get();
		view()->share('nhomsanpham',$nhomsanpham);
		view()->share('hangdt',$hangdt);
		view()->share('sanphammoi',$sanphammoi);
		view()->share('sanphammoi1',$sanphammoi1);
		view()->share('sanphammoi2',$sanphammoi2);
		view()->share('sanphambanchay',$sanphambanchay);
		view()->share('sanphamhotdeals',$sanphamhotdeals);
		view()->share('sanphambanchay1',$sanphambanchay1);
		view()->share('sanphambanchay2',$sanphambanchay2);
		view()->share('sanphamhotdeals1', $sanphamhotdeals1);
		view()->share('sanphamhotdeals2', $sanphamhotdeals2);
		
	}

    public function trangchu()
    {
		
    	return view('pages/trangchu');

    }

    public function getDangNhap()
    {
    	return view('pages/dangnhap');
    }

    public function postDangNhap(Request $request)
    {

    }

    public function getDangKy()
    {
    	return view('pages/dangky');
    }

    public function postDangKy(Request $request)
    {

    }

    public function loaitin()
    {
    	return view('pages/loaitin');
    }

    public function tintuc($id)
    {
    	return view('pages/tintuc');
    }

    public function danhmuc()
    {
    	$sanphamdt = DB::table('tbsanpham')->where('id_nhom','1')->get();
    	$sanphampk = DB::table('tbsanpham')->where('id_nhom','2')->get();
    	$sanphamapple = SanPham::where('id_hangdt','1')->get();
    	$sanphamsamsung = SanPham::where('id_hangdt','2')->get();
    	$sanphamsony = SanPham::where('id_hangdt','3')->get();
    	$sanphamnokia = SanPham::where('id_hangdt','4')->get();
    	$sanphamvsmart = SanPham::where('id_hangdt','5')->get();
    	$sanpham = DB::table('tbsanpham')->join('tbhangdt','tbsanpham.id_hangdt','tbhangdt.id')
    	->join('tbsoluongmausp','tbsanpham.id','tbsoluongmausp.id_sanpham')
    	->paginate(6);
    	return view('pages/danhmuc',
    		['sanpham' => $sanpham,
    		'sanphamdt' => $sanphamdt, 
    		'sanphampk' => $sanphampk,
    		'sanphamapple' => $sanphamapple,
    		'sanphamsamsung' => $sanphamsamsung,
    		'sanphamsony' => $sanphamsony,
    		'sanphamnokia' => $sanphamnokia,
    		'sanphamvsmart' => $sanphamvsmart,
    	]);
    }

    public function danhmuc1($id)
    {
    	$sanphamdt = DB::table('tbsanpham')->where('id_nhom','1')->get();
    	$sanphampk = DB::table('tbsanpham')->where('id_nhom','2')->get();
    	$sanphamapple = SanPham::where('id_hangdt','1')->get();
    	$sanphamsamsung = SanPham::where('id_hangdt','2')->get();
    	$sanphamsony = SanPham::where('id_hangdt','3')->get();
    	$sanphamnokia = SanPham::where('id_hangdt','4')->get();
    	$sanphamvsmart = SanPham::where('id_hangdt','5')->get();
    	$danhmuc = NhomSanPham::find($id);
    	$sanphamdanhmuc = SanPham::where('id_nhom',$id)->join('tbsoluongmausp','tbsanpham.id','tbsoluongmausp.id_sanpham')->paginate(6);
    	return view('pages/danhmuc1',
    		['danhmuc' => $danhmuc, 
    		'sanphamdanhmuc' => $sanphamdanhmuc,
    		'sanphamdt' => $sanphamdt, 
    		'sanphampk' => $sanphampk,
    		'sanphamapple' => $sanphamapple,
    		'sanphamsamsung' => $sanphamsamsung,
    		'sanphamsony' => $sanphamsony,
    		'sanphamnokia' => $sanphamnokia,
    		'sanphamvsmart' => $sanphamvsmart
		]);
    }

     public function danhmuc2($id)
    {
    	$sanphamdt = DB::table('tbsanpham')->where('id_nhom','1')->get();
    	$sanphampk = DB::table('tbsanpham')->where('id_nhom','2')->get();
    	$sanphamapple = SanPham::where('id_hangdt','1')->get();
    	$sanphamsamsung = SanPham::where('id_hangdt','2')->get();
    	$sanphamsony = SanPham::where('id_hangdt','3')->get();
    	$sanphamnokia = SanPham::where('id_hangdt','4')->get();
    	$sanphamvsmart = SanPham::where('id_hangdt','5')->get();
    	$danhmucloai = NhomSanPham::find($id);
    	$danhmuc = HangDT::find($id);
    	// $danhmuc = DB::table('tbhangdt')->join('tbsanpham','tbhangdt.id','tbsanpham.id_hangdt')
    	// ->join('tbnhomsanpham','tbsanpham.id_nhom','tbnhomsanpham.id');
    	$sanphamdanhmuc = SanPham::where('id_hangdt',$id)->join('tbsoluongmausp','tbsanpham.id','tbsoluongmausp.id_sanpham')->paginate(6);
    	return view('pages/danhmuc2',
    		['danhmuc' => $danhmuc, 
    		'sanphamdanhmuc' => $sanphamdanhmuc,
    		'danhmucloai' => $danhmucloai,
    		'sanphamdt' => $sanphamdt, 
    		'sanphampk' => $sanphampk,
    		'sanphamapple' => $sanphamapple,
    		'sanphamsamsung' => $sanphamsamsung,
    		'sanphamsony' => $sanphamsony,
    		'sanphamnokia' => $sanphamnokia,
    		'sanphamvsmart' => $sanphamvsmart
		]);
    }

    public function chitietsp($id)
    {
    	$chitiet = SanPham::find($id);
    	return view('pages/chitiet',['chitiet' => $chitiet]);
    }

    public function test()
    {
    	return view('pages/test');
    }

}
