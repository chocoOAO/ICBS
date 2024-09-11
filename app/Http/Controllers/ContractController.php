<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BreedingLog;
use App\Models\BreedingPerformance;
use App\Models\ChickenImport;
use App\Models\ChickenOut;
use App\Models\ChickenVerify;
use App\Models\Contract;
use App\Models\ContractDetail;
use App\Models\Contractsec;
use App\Models\FeedingLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;

class ContractController extends Controller
{
    public function list(Request $request)
    {
        if (!Gate::allows('view-contract')) {
            Gate::authorize('view-contract');
        }

        $request = $request;
        $contracts = null;
        if ($request->has('search')) {
            $columnNames = Schema::getColumnListing('contracts');
            $search = $request->search;
            //如果關鍵字包含保價、代養、合作飼養，則搜尋合約類型
            if (strpos($search, '保價') !== false) {
                $contracts = Contract::where('type', 'like', "1")->get();
                //只能看到自己主檔的合約
                if (auth()->user()->m_KUNAG != null) {
                    $contracts = $contracts->where('m_KUNAG', '=', auth()->user()->m_KUNAG);
                }
                $contracts = $contracts->sortByDesc('end_date');
                return view('contract.list')->with('contracts', $contracts);
            } else if (strpos($search, '代養') !== false) {
                $contracts = Contract::where('type', 'like', "2")->get();
                //只能看到自己主檔的合約
                if (auth()->user()->m_KUNAG != null) {
                    $contracts = $contracts->where('m_KUNAG', '=', auth()->user()->m_KUNAG);
                }
                $contracts = $contracts->sortByDesc('end_date');
                return view('contract.list')->with('contracts', $contracts);
            } else if (strpos($search, '合作飼養') !== false) {
                $contracts = Contract::where('type', 'like', "3")->get();
                //只能看到自己主檔的合約
                if (auth()->user()->m_KUNAG != null) {
                    $contracts = $contracts->where('m_KUNAG', '=', auth()->user()->m_KUNAG);
                }
                $contracts = $contracts->sortByDesc('end_date');
                return view('contract.list')->with('contracts', $contracts);
            }
            $query = Contract::query();
            foreach ($columnNames as $columnName) {
                $query = $query->orWhere($columnName, 'like', "%$search%");
            }
            $contracts = $query->get();

            //只能看到自己主檔的合約
            if (auth()->user()->m_KUNAG != null) {
                $contracts = $contracts->where('m_KUNAG', '=', auth()->user()->m_KUNAG);
            }

        } else {
            $contracts = Contract::all();
            //只能看到自己主檔的合約
            if (auth()->user()->m_KUNAG != null) {
                $contracts = $contracts->where('m_KUNAG', '=', auth()->user()->m_KUNAG);
            }
        }

        //根據結束日期與今天的差距排序
        $today = Carbon::today();
        // 过滤出已过期的合同
        $expiredContracts = $contracts->filter(function ($contract) use ($today) {
            return $today->greaterThan($contract->end_date);
        });
        // 获取未过期的合同
        $contracts = $contracts->diff($expiredContracts);
        // 排序未过期的合同
        $contracts = $contracts->sortBy('end_date');
        $expiredContracts = $expiredContracts->sortByDesc('end_date');

        return view('contract.list', [
            'contracts' => $contracts,
            'expiredContracts' => $expiredContracts,
        ]);
    }

    /**
     * 顯示合約
     *
     * @param Contract $contract
     * @return void
     */
    public function view(Contract $contract)
    {
        if (!Gate::allows('view-contract')) {
            Gate::authorize('view-contract');
        }

        return view('contract.view', [
            'contract' => $contract,
            'isEdit' => false,
        ]);
    }

    // 建立Contract
    public function create()
    {
        if (!Gate::allows('create-contract')) {
            Gate::authorize('create-contract');
        }

        return view('contract.create');
    }

    public function edit(Contract $contract, Request $request)
    {
        //驗證要傳入當前合約的id
        if (!Gate::allows('edit-contract', $contract)) {
            Gate::authorize('edit-contract', $contract);
        }
        return view('contract.view', [
            'contract' => $contract,
            'isEdit' => true,
        ]);
    }

    /**
     * 複製合約
     *
     * @param Contract $contract
     * @return void
     */
    public function copy(Contract $contract)
    {
        if (!Gate::allows('copy-contract', $contract)) {
            Gate::authorize('copy-contract', $contract);
        }

        return view('contract.view', [
            'contract' => $contract,
            'isEdit' => true,
        ]);
    }

    // 刪除Contract
    public function delete(Contract $contract)
    {
        if (!Gate::allows('delete-contract', $contract)) {
            Gate::authorize('delete-contract', $contract);
        }
        ChickenOut::where('contract_id', '=', $contract->id)->delete();
        BreedingLog::where('contract_id', '=', $contract->id)->delete();
        BreedingPerformance::where('contract_id', '=', $contract->id)->delete();
        FeedingLog::where('contract_id', '=', $contract->id)->delete();
        ChickenImport::where('contract_id', '=', $contract->id)->delete();
        ChickenVerify::where('contract_id', '=', $contract->id)->delete();
        ContractDetail::where('contract_id', '=', $contract->id)->delete();
        Contract::where('id', '=', $contract->id)->delete();
        return redirect('contracts');
    }

    // Restful API show

    public function show(Contract $contract)
    {
        echo "show";
    }

    // Restful API destroy
    // ToDo：檢查
    public function destroy($contract)
    {
        // echo "destory";
        if (is_null(Contract::find($contract))) {
            return response()->json(['message' => 'Contract not found!'], 404);
        }
        $contract = Contract::find($contract);
        // echo Contract::findorfail($contract);
        // return Contract::findorfail($contract)->delete();

        ChickenOut::where('contract_id', '=', $contract->id)->delete();
        BreedingLog::where('contract_id', '=', $contract->id)->delete();
        BreedingPerformance::where('contract_id', '=', $contract->id)->delete();
        FeedingLog::where('contract_id', '=', $contract->id)->delete();
        ChickenImport::where('contract_id', '=', $contract->id)->delete();
        ChickenVerify::where('contract_id', '=', $contract->id)->delete();
        ContractDetail::where('contract_id', '=', $contract->id)->delete();
        $contract->delete();
        return response()->json(['message' => 'Contract deleted!'], 200);
        // return redirect('contracts');
    }

    // JustTest 測試跟外部DB的連結狀況
    public function test2DB()
    {
        // $users = DB::connection('second_database')->table('contracts')->get();
        // echo $users;
        $users = Contractsec::all(); // 从第二个数据库获取用户数据
        echo $users;
        // $users = DB::connection('second_database')->table('users')->get();
        // echo $users;

        // $results = Contractsec::all();
        // echo $results;
    }
}
