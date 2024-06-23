<?php
/* ===================================================================
    사용자 필터
=================================================================== */

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class MaintenanceFilter implements FilterInterface
{

    /**
     * 서버정검 페이지
     * @param RequestInterface $request
     * @param $arguments
     * @return RedirectResponse|mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        return redirect()->to('/maintenance');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
