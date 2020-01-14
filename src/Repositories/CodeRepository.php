<?php

namespace MBLSolutions\InspiredDeckSupport\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use MBLSolutions\InspiredDeck\Balance;
use MBLSolutions\InspiredDeck\Issue;
use MBLSolutions\InspiredDeck\Credit;
use MBLSolutions\InspiredDeck\Debit;
use MBLSolutions\InspiredDeck\Block;
use MBLSolutions\InspiredDeck\Search;
use MBLSolutions\InspiredDeck\Transfer;
use MBLSolutions\InspiredDeckSupport\Product\Code;

class CodeRepository extends UserCacheRepository
{

    /**
     * Check Balance of Code
     *
     * @param Request $request
     * @return Code
     */
    public function balance(Request $request): Code
    {
        $code = (new Balance())->balance($request->toArray());

        return $this->setSelectedCode($code);
    }

    /**
     * Credit Code
     *
     * @param Request $request
     * @return Code
     */
    public function issue(Request $request): Code
    {
        $code = (new Issue)->issue($request->toArray());

        return $this->setSelectedCode($code);
    }

    /**
     * Credit Code
     *
     * @param Request $request
     * @return Code
     */
    public function credit(Request $request): Code
    {
        $code = (new Credit)->credit($request->toArray());

        return $this->setSelectedCode($code);
    }

    /**
     * Debit Code
     *
     * @param Request $request
     * @return Code
     */
    public function debit(Request $request): Code
    {
        $code = (new Debit)->debit($request->toArray());

        return $this->setSelectedCode($code);
    }

    /**
     * Block Code
     *
     * @param Request $request
     * @return Code
     */
    public function block(Request $request): Code
    {
        $code = (new Block)->block($request->toArray());

        return $this->setSelectedCode($code);
    }

    /**
     * Block Code
     *
     * @param Request $request
     * @return Code
     */
    public function transfer(Request $request): Code
    {
        $code = (new Transfer)->transfer($request->toArray());

        return $this->setSelectedCode($code);
    }

    /**
     * Refresh Code
     *
     * @param int $serial
     * @return Code
     */
    public function refresh(int $serial): Code
    {
        $code = $this->model()->refresh($serial);

        return $this->setSelectedCode($code);
    }

    /**
     * Search Controller
     *
     * @param Request $request
     * @return Code|Collection
     */
    public function search(Request $request)
    {
        $result = (new Search())->code($request->toArray());

        if (isset($result['meta'])) {
            $this->resetSelectedCode();

            return collect($result);
        }

        return $this->setSelectedCode($result);
    }

    /**
     * Get Selected Code
     *
     * @param mixed $default
     * @return mixed
     */
    public function getSelectedCode($default = null)
    {
        $d = $this->get('selected_code', $default);

        return $d;
    }

    /**
     * Set/Update the Selected Code Information
     *
     * @param $code
     * @return Code
     */
    private function setSelectedCode($code): Code
    {
        if (!$code instanceof Code) {
            $code = new Code($code['data'] ?? $code);
        }

        $this->put('selected_code', $code->toJson());

        return $code;
    }

    /**
     * Reset the Selected Code Information
     *
     * @return void
     */
    private function resetSelectedCode(): void
    {
        $this->put('selected_code', null);
    }

    /**
     * Get the model
     *
     * @return mixed
     */
    protected function model()
    {
        return new Code;
    }

}
