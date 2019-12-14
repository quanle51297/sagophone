<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Mail;

use Hash;

use Illuminate\Support\Str;

use App\Mail\SendMail;

use App\NhomSanPham;

use App\SanPham;

use App\HangDT;

use App\DanhSachBanner;

use App\Banner;

use App\Mau;

use App\ChiTietSanPham;

use App\LoaiTin;

use App\TinTuc;

use App\Cart;

use App\BinhLuan;

use App\ThanhVien;

use App\NhanVien;

use App\KhoangGia;

use App\Mail\verifyEmail;

use App\Mail\forgotPassword;

use DB;

use Session;

class PageController extends Controller
{

	function __construct()
	{
		$nhomsanpham = NhomSanPham::all();
		$hangdt = HangDT::all();
		$sanphammoi =       DB::table('tbchitietsanpham')
                            ->join('tbsanpham','tbchitietsanpham.id_sanpham','tbsanpham.id')
                            ->join('tbhangdt','tbsanpham.id_hangdt','tbhangdt.id')
                            ->join('tbdanhsachbanner','tbchitietsanpham.id','tbdanhsachbanner.id_chitietsanpham')
                            ->join('tbmau','tbchitietsanpham.id_mau','tbmau.id')
                            ->join('tbbanner','tbdanhsachbanner.id_banner','tbbanner.id')
                            ->where('tbdanhsachbanner.id_banner',3)
                            ->select('tbsanpham.tensp','tbhangdt.tenhang','tbsanpham.hinhsp','tbchitietsanpham.*','tbdanhsachbanner.phantramkhuyenmai', 'tbdanhsachbanner.id_banner','tbmau.mau','tbbanner.trangthai')
                            ->get();
		$sanphambanchay =   DB::table('tbchitietsanpham')
                            ->join('tbsanpham','tbchitietsanpham.id_sanpham','tbsanpham.id')
                            ->join('tbhangdt','tbsanpham.id_hangdt','tbhangdt.id')
                            ->join('tbdanhsachbanner','tbchitietsanpham.id','tbdanhsachbanner.id_chitietsanpham')
                            ->join('tbmau','tbchitietsanpham.id_mau','tbmau.id')
                            ->join('tbbanner','tbdanhsachbanner.id_banner','tbbanner.id')
                            ->whereIn('tbchitietsanpham.id',getBanchay())
                            ->select('tbsanpham.tensp','tbhangdt.tenhang','tbsanpham.hinhsp','tbchitietsanpham.*','tbdanhsachbanner.phantramkhuyenmai', 'tbdanhsachbanner.id_banner','tbmau.mau', 'tbbanner.trangthai')
                            ->get();
		view()->share('nhomsanpham',$nhomsanpham);
		view()->share('hangdt',$hangdt);
		view()->share('sanphammoi',$sanphammoi);
		view()->share('sanphambanchay',$sanphambanchay);
	}

    public function trangchu()
    {
        $banner = Banner::all();
        $apple = SanPham::join('tbhangdt','tbsanpham.id_hangdt','tbhangdt.id')
        ->where('id_hangdt',1)->inRandomOrder()->first();
        $samsung = SanPham::join('tbhangdt','tbsanpham.id_hangdt','tbhangdt.id')
        ->where('id_hangdt',2)->inRandomOrder()->first();
        $nokia = SanPham::join('tbhangdt','tbsanpham.id_hangdt','tbhangdt.id')
        ->where('id_hangdt',4)->inRandomOrder()->first();
        $bannerhotdeals = Banner::where('id',2)->first();
        $bannernew = Banner::where('id',3)->first();
        $bannerbanchay = Banner::where('id',4)->first();
        
        $dienthoai = DB::table('tbchitietsanpham')
                            ->join('tbsanpham','tbchitietsanpham.id_sanpham','tbsanpham.id')
                            ->join('tbhangdt','tbsanpham.id_hangdt','tbhangdt.id')
                            ->join('tbmau','tbchitietsanpham.id_mau','tbmau.id')
                            ->where('tbsanpham.id_nhom',1)
                            ->select('tbsanpham.tensp','tbhangdt.tenhang','tbsanpham.hinhsp','tbchitietsanpham.*','tbmau.mau')
                            ->inRandomOrder()->take(20)->get();
        $phukien = DB::table('tbchitietsanpham')
                            ->join('tbsanpham','tbchitietsanpham.id_sanpham','tbsanpham.id')
                            ->join('tbhangdt','tbsanpham.id_hangdt','tbhangdt.id')
                            ->join('tbmau','tbchitietsanpham.id_mau','tbmau.id')
                            ->where('tbsanpham.id_nhom',2)
                            ->select('tbsanpham.tensp','tbhangdt.tenhang','tbsanpham.hinhsp','tbchitietsanpham.*','tbmau.mau')
                            ->inRandomOrder()->take(20)->get();                
        $tintuc = TinTuc::join('tbloaitin','tbtintuc.id_loaitin','tbloaitin.id')->select('tbloaitin.tenloaitin','tbtintuc.*');

        $tintuc = $tintuc->paginate(6);
    	return view('pages/trangchu',[
            'apple' => $apple,
            'banner' => $banner,
            'samsung' => $samsung,
            'nokia' => $nokia,
            'bannerhotdeals' => $bannerhotdeals,
            'bannernew' => $bannernew,
            'bannerbanchay' => $bannerbanchay,
            'dienthoai' => $dienthoai,
            'phukien' => $phukien,
            'tintuc' => $tintuc
        ]);
    	
    }

    public function loaitin(Request $request)
    {
        $loaitin = LoaiTin::all();
        $tintuc = DB::table('tbtintuc');
        if($request->id)
        {
            $idlt = $request->id;
            $tintuc->where('id_loaitin',$idlt);

        }
        if($request->id)
        {
            $tinmoi = TinTuc::orderBy('created_at','DESC')->where('id_loaitin',$request->id)->first();
            $tinmoi1 = TinTuc::orderBy('created_at','DESC')->where('id_loaitin',$request->id)->whereNotIn('id',$tinmoi)->take(2)->get();
            $tinmoi2 = TinTuc::orderBy('created_at','DESC')->where('id_loaitin',$request->id)->whereNotIn('id_loaitin',$tinmoi)->whereNotIn('id_loaitin',$tinmoi1)->get();
        }
        else
        {
            $tinmoi = TinTuc::orderBy('created_at','DESC')->first();
            $tinmoi1 = TinTuc::orderBy('created_at','DESC')->skip(1)->take(2)->get();
            foreach($tinmoi1 as $tm1)
            {
                $tinmoi2 = TinTuc::orderBy('created_at','DESC')
                        ->where('id','!=',$tinmoi->id)->whereNotIn('id',$tm1)->get();
            }
        }
    	return view('pages/loaitin',['loaitin' => $loaitin, 'tintuc' => $tintuc, 
            'tinmoi' => $tinmoi,
            'tinmoi1' => $tinmoi1,
            'tinmoi2' => $tinmoi2
        ]);
    }

    public function tintuc($id)
    {
        $tintuc = TinTuc::find($id);
        $tinlienquan = TinTuc::where('id_loaitin',$tintuc->id_loaitin)->where('id','<>',$id)->take(3)->get();
        $tinkhac = TinTuc::where('id_loaitin','<>',$tintuc->id_loaitin)->take(3)->get();
        $tinketiep = TinTuc::where('id_loaitin',$tintuc->id_loaitin)->where('id','<>',$id)->first();
        $tenadmin = NhanVien::where('id',$tintuc->id_admins)->value('name');
        $banner = Banner::all();
    	return view('pages/tintuc',['tintuc' => $tintuc, 'tinlienquan' => $tinlienquan, 
            'tinkhac' => $tinkhac,
            'tinketiep' => $tinketiep,
            'tenadmin' => $tenadmin,
            'banner' => $banner
        ]);
    }

    public function dienthoai(Request $request)
    {
    	$sanphamdt = DB::table('tbchitietsanpham')->join('tbsanpham','tbchitietsanpham.id_sanpham','tbsanpham.id')->where('id_nhom','1')->get();
        $sanpham = DB::table('tbchitietsanpham')
                    ->join('tbsanpham','tbchitietsanpham.id_sanpham','tbsanpham.id')
                    ->join('tbhangdt','tbsanpham.id_hangdt','tbhangdt.id')
                    ->join('tbmau','tbchitietsanpham.id_mau','tbmau.id')
                    ->where('tbsanpham.id_nhom',1)
                    ->select('tbsanpham.tensp','tbsanpham.id_nhom','tbhangdt.tenhang','tbsanpham.hinhsp','tbchitietsanpham.*','tbmau.mau');
        if($request->price)
        {
                $price = $request->price;
                switch ($price) {
                    case '1':
                        $sanpham->where('gia','<',1000000)->orderBy('gia','ASC');
                        break;
                    case '2' :
                        $sanpham->whereBetween('gia',[1000000,3000000])->orderBy('gia','ASC');
                        break;
                    case '3' :
                        $sanpham->whereBetween('gia',[3000000,5000000])->orderBy('gia','ASC');
                        break;
                    case '4' :
                        $sanpham->whereBetween('gia',[5000000,7000000])->orderBy('gia','ASC');
                        break;
                    case '5' :
                        $sanpham->whereBetween('gia',[7000000,1000000])->orderBy('gia','ASC');
                        break;
                     case '6':
                        $sanpham->where('gia','>',10000000)->orderBy('gia','ASC');
                        break;
                    default:
                       
                }
                
        }
        if($request->rom)
        {
            $rom = $request->rom;
            $sanpham = $sanpham->where('rom',$rom);
                
        }

        if($request->id_nhom)
        {
            $id_nhom = $request->id_nhom;
            switch ($id_nhom) {
                case '1':
                    $sanpham->where('id_nhom','1');
                    break;
                case '2':
                    $sanpham->where('id_nhom','2');
                default:
                    # code...
                    break;
            }
        }

        if($request->grand)
        {
            $grand = $request->grand;
            $sanpham = $sanpham->where('id_hangdt',$grand);
               
        }

        if($request->id_banner)
        {
            $sanpham = $sanpham->join('tbdanhsachbanner','tbchitietsanpham.id','tbdanhsachbanner.id_chitietsanpham')
                    ->where('id_banner',$request->id_banner);
            $hinhbanner = Banner::where('id',$request->id_banner)->select('id','hinhbanner')->first();
        }
        else
            $hinhbanner = null;

        if($request->sortby)
        {
            $sortby = $request->sortby;
            switch ($sortby) {
                case 'tangdan':
                    $sanpham->orderBy('gia','ASC');
                    break;
                case 'giamdan':
                    $sanpham->orderBy('gia','DESC');
                    break;
                default:
                    
                    break;
            }
        }

        if(isset($request->pricemin) && isset($request->pricemax))
        {
            $max = $request->pricemax;
            $min = $request->pricemin;
            $sanpham->where('gia','>=',$min)->where('gia','<=',$max);
        }

        $sanpham = $sanpham->paginate(6);
        $thuonghieu = HangDT::all();
        $rom = SanPham::select('rom')->distinct()->orderBy('rom','ASC')->get();
        $khoanggia = KhoangGia::all();
    	return view('pages/dienthoai',
    		['sanpham' => $sanpham,
    		'sanphamdt' => $sanphamdt, 
    		'thuonghieu' => $thuonghieu,
            'rom' => $rom,
            'khoanggia' => $khoanggia,
            'hinhbanner' => $hinhbanner,
    	]);
        //var_dump($request->orderby);
    }

    public function phukien(Request $request)
    {
        $sanphampk = DB::table('tbchitietsanpham')->join('tbsanpham','tbchitietsanpham.id_sanpham','tbsanpham.id')->where('id_nhom','2')->get();
        $sanpham = DB::table('tbchitietsanpham')
                    ->join('tbsanpham','tbchitietsanpham.id_sanpham','tbsanpham.id')
                    ->join('tbhangdt','tbsanpham.id_hangdt','tbhangdt.id')
                    ->join('tbmau','tbchitietsanpham.id_mau','tbmau.id')
                    ->where('tbsanpham.id_nhom',2)
                    ->orderBy('tbsanpham.created_at','desc')
                    ->select('tbsanpham.tensp','tbsanpham.id_nhom','tbhangdt.tenhang','tbsanpham.hinhsp','tbchitietsanpham.*','tbmau.mau');
        if($request->price)
        {
                $price = $request->price;
                switch ($price) {
                    case '1':
                        $sanpham->where('gia','<',1000000)->orderBy('gia','ASC');
                        break;
                    case '2' :
                        $sanpham->whereBetween('gia',[1000000,3000000])->orderBy('gia','ASC');
                        break;
                    case '3' :
                        $sanpham->whereBetween('gia',[3000000,5000000])->orderBy('gia','ASC');
                        break;
                    case '4' :
                        $sanpham->whereBetween('gia',[5000000,7000000])->orderBy('gia','ASC');
                        break;
                    case '5' :
                        $sanpham->whereBetween('gia',[7000000,1000000])->orderBy('gia','ASC');
                        break;
                     case '6':
                        $sanpham->where('gia','>',10000000)->orderBy('gia','ASC');
                        break;
                    default:
                       
                }
                
        }
        if($request->rom)
        {
            $rom = $request->rom;
            $sanpham = $sanpham->where('rom',$rom);
                
        }

        if($request->id_nhom)
        {
            $id_nhom = $request->id_nhom;
            switch ($id_nhom) {
                case '1':
                    $sanpham->where('id_nhom','1');
                    break;
                case '2':
                    $sanpham->where('id_nhom','2');
                default:
                    # code...
                    break;
            }
        }

        if($request->grand)
        {
            $grand = $request->grand;
            $sanpham = $sanpham->where('id_hangdt',$grand);
               
        }
        if($request->id_banner)
        {
            $sanpham = $sanpham->join('tbdanhsachbanner','tbchitietsanpham.id','tbdanhsachbanner.id_chitietsanpham')
                    ->where('id_banner',$request->id_banner);
            $hinhbanner = Banner::where('id',$request->id_banner)->select('id','hinhbanner')->first();
        }
        else
            $hinhbanner = null;
        $sanpham = $sanpham->paginate(6);
        $thuonghieu = HangDT::all();
        $rom = SanPham::select('rom')->distinct()->orderBy('rom','ASC')->get();
        $khoanggia = KhoangGia::all();
        $banner = Banner::all();
        return view('pages/phukien',
            ['sanpham' => $sanpham,
            'sanphampk' => $sanphampk,
            'thuonghieu' => $thuonghieu,
            'rom' => $rom,
            'khoanggia' => $khoanggia,
            'banner' => $banner,
            'hinhbanner' => $hinhbanner
        ]);
    }

    public function chitietsp($id, Request $request)
    {
    	$chitiet = ChiTietSanPham::find($id);
    	$sanphamlienquan =   DB::table('tbchitietsanpham')
                            ->join('tbsanpham','tbchitietsanpham.id_sanpham','tbsanpham.id')
                            ->join('tbhangdt','tbsanpham.id_hangdt','tbhangdt.id')
                            ->join('tbdanhsachbanner','tbchitietsanpham.id','tbdanhsachbanner.id_chitietsanpham')                          
                            ->where('tbchitietsanpham.id','<>',$id)
                            ->select('tbsanpham.tensp','tbhangdt.tenhang','tbsanpham.hinhsp','tbchitietsanpham.*','tbdanhsachbanner.phantramkhuyenmai','tbdanhsachbanner.id_banner')
                            ->where('id_nhom',$chitiet->sanpham->id_nhom)
                            ->inRandomOrder()->take(4)->get();
    	//var_dump(getGiaMin($id));
        $hinhchitiet = ChiTietSanPham::where('id_sanpham',$chitiet->id_sanpham)->get();
        if($request->id_mau)
            {
             $chitiet = $chitiet->where('id_sanpham',$chitiet->id_sanpham)->where('id_mau',$request->id_mau)->first();
            }
        
        else
            $chitiet = $chitiet;
        
    	return view('pages/chitiet',['chitiet' => $chitiet, 'sanphamlienquan' => $sanphamlienquan, 'hinhchitiet' => $hinhchitiet]);
    }


    public function timkiem(Request $request)
    {
        $keyword = $request->keyword;
        if($keyword == null && $request->timkiem == null)
        {
            return redirect()->back()->with('thongbao','Vui lòng chọn hãng hoặc nhập từ khóa!');
        }
        if($keyword == null && $request->timkiem !=null)
        {
            $sanpham = DB::table('tbchitietsanpham')
                        ->join('tbsanpham','tbchitietsanpham.id_sanpham','tbsanpham.id')
                        ->join('tbhangdt','tbsanpham.id_hangdt','tbhangdt.id')
                        ->join('tbmau','tbchitietsanpham.id_mau','tbmau.id')
                        ->where('id_hangdt',$request->timkiem)
                        ->select('tbsanpham.tensp','tbhangdt.tenhang','tbsanpham.hinhsp','tbchitietsanpham.*','tbmau.mau');
        }

        else if($keyword != null && $request->timkiem ==null)
        {
           
                $sanpham = DB::table('tbchitietsanpham')
                            ->join('tbsanpham','tbchitietsanpham.id_sanpham','tbsanpham.id')
                            ->join('tbhangdt','tbsanpham.id_hangdt','tbhangdt.id')
                            ->join('tbmau','tbchitietsanpham.id_mau','tbmau.id')
                            ->where('tensp','like','%'.$keyword.'%')
                            ->orWhere('mota','like','%'.$keyword.'%')
                            ->select('tbsanpham.tensp','tbhangdt.tenhang','tbsanpham.hinhsp','tbchitietsanpham.*','tbmau.mau');
            
        }  
        else
        {
             $sanpham = DB::table('tbchitietsanpham')
                            ->join('tbsanpham','tbchitietsanpham.id_sanpham','tbsanpham.id')
                            ->join('tbhangdt','tbsanpham.id_hangdt','tbhangdt.id')
                            ->join('tbmau','tbchitietsanpham.id_mau','tbmau.id')
                            ->where('id_hangdt',$request->timkiem)
                            ->where('tensp','like','%'.$keyword.'%')
                            ->orWhere('mota','like','%'.$keyword.'%')
                            ->select('tbsanpham.tensp','tbhangdt.tenhang','tbsanpham.hinhsp','tbchitietsanpham.*','tbmau.mau');
        }

       
        $tongsanpham = $sanpham->get();
        $khoanggia = KhoangGia::all();
        $tenhang = HangDT::where('id',$request->timkiem)->value('tenhang');
        $sanpham = $sanpham->paginate(6);
        return view('pages/timkiem',['keyword' => $keyword, 'sanpham' => $sanpham, 
            'tongsanpham' => $tongsanpham,
            'tenhang' => $tenhang,
            'khoanggia' => $khoanggia]);
        
    }

    public function lienhe()
    {
        return view('pages.lienhe');
    }

    public function postLienhe(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required',
                'email' => 'required',
                'phanhoi' => 'required'
            ],
            [
                'name.required' => 'Chưa nhập tên!',
                'email.required' => 'Chưa nhập email!',
                'phanhoi.required' => 'Chưa nhập phản hồi!'
            ]
        );
        $data = ['name' => $request->name, 'mail' => $request->email, 'content' => $request->phanhoi];
        Mail::send('pages/blank',$data,function($msg) use ($data){
            $msg->from($data['mail'], $data['name']);
            $msg->to('momaomao1@gmail.com','SagoPhone')->subject('Phản Hồi Của Người Dùng');
        });

        return redirect('lienhe')->with('phanhoithanhcong','Gửi phản hồi thành công!');; 
    }

    public function binhluan(Request $request, $id)
    {
        $sanpham = SanPham::find($id);
        $binhluan = new BinhLuan;
        $binhluan->id_sanpham = $id;
        $binhluan->id_thanhvien = Auth::user()->id;
        $binhluan->binhluan = $request->binhluan;
        $binhluan->save();
        return redirect("chitiet/$id/".$sanpham->id.".html")->with('thongbao','Bình luận thành công!');
    }

    public function getNguoiDung()
    {
        return view('pages.nguoidung');
    }

    public function postNguoiDung(Request $request)
    {
        $user = Auth::user();
        $this->validate($request,
            [
                'Name' => 'required|min:5',
                // 'Email' => 'required|unique:users,email',
              
            ],
            [
                'Name.required' => 'Bạn chưa nhập tên người dùng!',
                'Name.min' => 'Tên người dùng phải có ít nhất 3 ký tự!'
                // 'Email.required' => 'Bạn chưa nhập email!',
                // 'Email.email' => 'Bạn nhập chưa đúng dạng email!',
                // 'Email.unique' => 'Email đã có người sử dụng!',
               
            ]
        );
        $user->name = $request->Name;
        $user->diachi = $request->Address;
        if($request->changePassword == "on")
        {
            if(Hash::check($request->oldPassword, $user->password,[]))
            {
                    $this->validate($request,
                [
                    
                    'Password' => 'required|min:6|max:30',
                    'againPassword' => 'required|same:Password'
                ],
                [
                    'Password.required' => 'Bạn chưa nhập mật khẩu!',
                    'Password.min' => 'Mật khẩu phải có nhiều hơn 6 ký tự!',
                    'Password.max' => 'Mật khẩu không được nhiều hơn 30 ký tự!',
                    'againPassword.required' => 'Bạn chưa nhập lại mật khẩu!',
                    'againPassword.same' => 'Mật khẩu không trùng khớp!',             
                ]);
                $user->password = bcrypt($request->Password);
            }
            else
            {
                return redirect('nguoidung')->with('thongbaomatkhau','Mật khẩu cũ không đúng!');
            }
        }
        $user->sdt = $request->Phone;
        $user->save();
        return redirect('nguoidung')->with('thongbaonguoidung','Bạn đã sửa thành công');
    }

    public function getDangKy()
    {
        return view('pages.dangky');
    }

    public function postDangKy(Request $request)
    {
        $this->validate($request,
            [
                'Ten' => 'required|min:5|unique:tbthanhvien,username',
                'Email' => 'required|unique:tbthanhvien,email',
                'Password' => 'required|min:6|max:30',
                'againPassword' => 'required|same:Password'
            ],
            [
                'Ten.required' => 'Bạn chưa nhập tên đăng nhập!',
                'Ten.min' => 'Tên đăng nhập phải có ít nhất 3 ký tự!',
                'Ten.unique' => 'Đã có người sử dụng tên!',
                'Email.required' => 'Bạn chưa nhập email!',
                'Email.email' => 'Bạn nhập chưa đúng định dạng email!',
                'Email.unique' => 'Email đã có người sử dụng!',
                'Password.required' => 'Bạn chưa nhập mật khẩu!',
                'Password.min' => 'Mật khẩu phải có nhiều hơn 6 ký tự!',
                'Password.max' => 'Mật khẩu không được nhiều hơn 30 ký tự!',
                'againPassword.required' => 'Bạn chưa nhập lại mật khẩu!',
                'againPassword.same' => 'Mật khẩu không trùng khớp!',             
            ]
        );
        $user = new ThanhVien;
        $user->username = $request->Ten;
        $user->email = $request->Email;
        $user->password = bcrypt($request->Password);
        $user->verifyToken = Str::random(40);
        $user->save();
        Mail::to($user->email)->send(new verifyEmail($user));
        return redirect('dangky')->with('thongbaodangky','Đăng ký tài khoản thành công! Vui lòng truy cập mail để kích hoạt!');
    }

    public function sendEmailDone($id, $verifyToken)
    {
        $user = ThanhVien::where('id',$id)->where('verifyToken',$verifyToken)->first();
        if($user)
        {
            $user->trangthai = 1;
            $user->verifyToken = NULL;
            $user->save();
        }
        else
        {
            echo "user not found";
        }
        return redirect('registersuccess');
    }

    public function registerSuccess()
    {
        return view('pages/registersuccess');
    }

    public function getDangNhap()
    {
        return view('pages.dangnhap');
    }

    public function postDangNhap(Request $request)
    {
        $this->validate($request,
            [
                'email' => 'required',
                'password' => 'required'
            ],
            [
                'email.required' => 'Bạn chưa nhập email!',
                'password.required' => 'Bạn chưa nhập password!'
            ]
        );
        if(Auth::attempt(['username' => $request->email, 'password' => $request->password, 'trangthai' => 1])
        || Auth::attempt(['email' => $request->email, 'password' => $request->password, 'trangthai' => 1]))
            {
              return redirect('trangchu');
            }          
        else
            {
                if(Auth::attempt(['username' => $request->email, 'password' => $request->password, 'trangthai' => 0])
        || Auth::attempt(['email' => $request->email, 'password' => $request->password, 'trangthai' => 0]))
                {
                    return redirect('dangnhap')->with('thongbaodangnhap','Tài khoản chưa được kích hoạt!');
                }
                else
                    return redirect('dangnhap')->with('thongbaodangnhap','Sai tên đăng nhập, Email hoặc mật khẩu');
            }
    }

   
    public function dangxuat()
    {
        Auth::logout();
        return redirect('trangchu');
    }

    public function forgotPassword()
    {
        return view('pages/quenmatkhau');
    }

    public function postForgotPassword(Request $request)
    {
         $user = ThanhVien::where('username',$request->name)->where('email', $request->email)->first();
         if($user)
         {
            $user->verifyToken = Str::random(40);
            $user->save();
            Mail::to($request->email)->send(new forgotPassword($user));
            return redirect('quenmatkhau')->with('thongbaoguiquen','Đã gửi thông tin reset password qua mail!');
         }
         else
         {
            return redirect('quenmatkhau')->with('thongbaoquen','Không tìm thấy tài khoản trong hệ thống!');
         }
    }

    public function resetPassword($id, $verifyToken)
    {
        return view('pages/resetpassword',['id' => $id, 'verifyToken' => $verifyToken]);
    }

    public function postResetPassword(Request $request, $id)
    {
        $user = ThanhVien::find($id);
        $user->password =  bcrypt($request->newPassword);
        $user->verifyToken = NULL;
        $user->save();
        return redirect('dangnhap')->with('thongbaoreset','Reset mật khẩu thành công!');
    }
}
