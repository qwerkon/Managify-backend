<?php
namespace App\Domains\Http\Jobs;

use Lucid\Foundation\Job;
use App\Data\Transformers\CompanyTransformer;

class FormatCompanyToJsonJob extends Job
{
    private $company;
    private $transformer;
    private $toHide;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $company, $toHide = [] )
    {
        $this->company = $company;
        $this->transformer = new CompanyTransformer();
        $this->toHide = $toHide;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return $this->transformer->transform( $this->company, $this->toHide  );
    }
}
