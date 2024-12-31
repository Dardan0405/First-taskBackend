<?php
namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**compo
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
       '/user-regist',
       '/instructor-register',
       '/admin-register',
       '/user-login',
       '/instructor-login',
       '/admin-login',
       '/users',
       '/users-details',
       '/courses',
       '/course',
       '/courses/create',
       '/courses/enroll',
       '/courses/delete',
       '/courses/thread',
       '/threads/post',
       '/threads/reply',
       '/replies/delete',
       '/replies/deleteuser'

    ];
}
