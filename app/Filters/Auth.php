<?php namespace App\Filters;

use App\Models\TahunAjarModel;
use App\Models\UserModel;
use App\Models\WaliKelasModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
 
class Auth implements FilterInterface
{
    protected $user;
    protected $wali_kelas;
    protected $tahun_ajar;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->wali_kelas = new WaliKelasModel();
        $this->tahun_ajar = new TahunAjarModel();
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        if(! session()->get('logged_in')){
            return redirect()->to(route_to('login_form')); 
        }

        if((session()->get('level') == 'guru') and (session()->get('is_wali') == null)){
            $user = $this->user->getData(session()->get('id'));
            $id_tahun_ajar = $this->tahun_ajar->getActiveId();
            $wali_kelas = $this->wali_kelas->where([
                'id_guru_wali' => $user['id'],
                'id_tahun_ajar' => $id_tahun_ajar
            ])->findAll();
            $is_wali = count($wali_kelas) > 0 ? true : false;
            session()->set([
                'is_wali' => $is_wali
            ]);
        };
    }
 
    //--------------------------------------------------------------------
 
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}