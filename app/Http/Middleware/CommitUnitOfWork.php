<?php declare(strict_types=1);


namespace App\Http\Middleware;


use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;

class CommitUnitOfWork
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle($request, Closure $next)
    {
        $response = $next($request);

        /** @var Request $request*/
        if (!$request->isMethodSafe())
        {
            $this->entityManager->flush();
        }

        return $response;
    }
}
