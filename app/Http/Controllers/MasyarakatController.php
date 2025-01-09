<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Masyarakat; //panggil model
use Illuminate\Support\Facades\DB; // jika pakai query builder
use Illuminate\Database\Eloquent\Model; //jika pakai eloquent
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MasyarakatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        //$ar_masyarakat = Masyarakat::all();//eloquent
        $ar_masyarakat = Masyarakat::orderBy('id', 'desc')->get();
        return view('backend.masyarakat.index', compact('ar_masyarakat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        //ambil master data kategori u/ dilooping di select option form
        $ar_gender = ['L','P'];
        return view('backend.masyarakat.form', compact('ar_gender'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            //tentukan validasi data berdasarkan constraint field
            [
                'nama' => 'required|max:45',
                'gender' => 'required',
                'umur' => 'required|integer',
                'berat_badan' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/', //double
                'tinggi_badan' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/', //double
            ],
           
        );

        Masyarakat::create($request->all());
        return redirect()->route('masyarakat.index')->with('success','Masyarakat created successfully!!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rs = Masyarakat::find($id);
        return view('backend.masyarakat.detail',compact('rs'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //ambil master untuk dilooping di select option
        $ar_kategori = Kategori::all();
        $ar_kondisi = ['Baik','Sedang','Rusak'];
        //tampilkan data lama di form edit
        $row = Masyarakat::find($id);
        return view('backend.masyarakat.form_edit',compact('row','ar_kategori','ar_kondisi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate(
            //tentukan validasi data berdasarkan constraint field
            [
                'nama' => 'required|max:45',
                'kategori_id' => 'required|integer',
                'thn_beli' => 'required|integer',
                'harga' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/', //double
                'masa_umur' => 'required|between:0,99.99', //float
                'kondisi' => 'required',
                'lokasi' => 'required',
                'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|min:2|max:9000',//KB
            ],
            //custom pesan errornya berbahasa indonesia
            [
                'nama.required'=>'Nama Wajib Diisi',
                'nama.max'=>'Nama Maksimal 45 karakter',
                'kategori_id.required'=>'Kategori Wajib Diisi',
                'thn_beli.required'=>'Tahun Beli Wajib Diisi',
                'thn_beli.integer'=>'Tahun Beli Harus Bilangan Bulat',
                'harga.required'=>'Harga Wajib Diisi',
                'harga.regex'=>'Harga Harus Berupa Angka',
                'masa_umur.required'=>'Masa Umur Wajib Diisi',
                'masa_umur.between'=>'Masa Umur Bilangan Pecahan',
                'kondisi.required'=>'Kondisi Wajib Diisi',
                'lokasi.required'=>'Lokasi Wajib Diisi',
                'foto.min'=>'Ukuran file kurang 2 KB',
                'foto.max'=>'Ukuran file melebihi 9000 KB',
                'foto.image'=>'File foto bukan gambar',
                'foto.mimes'=>'Extension file selain jpg,jpeg,png,gif,svg',
            ]
        );
        //------------ambil foto lama apabila user ingin ganti foto-----------
        $foto = DB::table('masyarakat')->select('foto')->where('id',$id)->get();
        foreach($foto as $f){
            $namaFileFotoLama = $f->foto;
        }
        //------------apakah user  ingin ubah upload foto baru-----------
        if(!empty($request->foto)){
            //jika ada foto lama, hapus foto lamanya terlebih dahulu
            if(!empty($namaFileFotoLama)) unlink('backend/masyarakats/img/'.$namaFileFotoLama);
            //lalukan proses ubah foto lama menjadi foto baru
            $fileName = 'masyarakat_'.date("Ymd_h-i-s").'.'.$request->foto->extension();
            //$fileName = $request->foto->getClientOriginalName();
            $request->foto->move(public_path('backend/masyarakats/img'),$fileName);
        }
        else{
            $fileName = $namaFileFotoLama;
        }
        //lakukan update data dari request form edit
        DB::table('masyarakat')->where('id',$id)->update(
            [
                'nama'=>$request->nama,
                'kategori_id'=>$request->kategori_id,
                'thn_beli'=>$request->thn_beli,
                'harga'=>$request->harga,
                'masa_umur'=>$request->masa_umur,
                'kondisi'=>$request->kondisi,
                'lokasi'=>$request->lokasi,
                'foto'=>$fileName,
            ]);
       
        return redirect('/masyarakat'.'/'.$id)
                        ->with('success','Data Masyarakat Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //sebelum hapus data, hapus terlebih dahulu fisik file fotonya jika ada
        $row = Masyarakat::find($id);
        if(!empty($row->foto)) unlink('backend/masyarakats/img/'.$row->foto);
        //hapus datanya dari tabel
        Masyarakat::where('id',$id)->delete();
        return redirect()->route('masyarakat.index')
                        ->with('success','Data Masyarakat Berhasil Dihapus');
    }

    public function delete($id)
    {
        //sebelum hapus data, hapus terlebih dahulu fisik file fotonya jika ada
        $row = Masyarakat::find($id);
        if(!empty($row->foto)) unlink('backend/masyarakats/img/'.$row->foto);
        //hapus datanya dari tabel
        Masyarakat::where('id',$id)->delete();
        return redirect()->back();
    } 

    public function generatePDF()
    {
        $data = [
            'title' => 'Welcome to Kampus Merdeka',
            'date' => date('d-m-Y H:i:s')
        ];
          
        $pdf = PDF::loadView('backend.masyarakat.tesPDF', $data);
    
        return $pdf->download('data_tespdf_'.date('d-m-Y_H:i:s').'.pdf');
    }

    public function masyarakatPDF(){
        $ar_masyarakat = Masyarakat::all();
        $pdf = PDF::loadView('backend.masyarakat.masyarakatPDF', 
                              ['ar_masyarakat'=>$ar_masyarakat]);
        return $pdf->download('data_masyarakat_'.date('d-m-Y_H:i:s').'.pdf');
    }

    public function masyarakatExcel() 
    {
        return Excel::download(new MasyarakatExport, 'data_masyarakat_'.date('d-m-Y_H:i:s').'.xlsx');
    }
}
