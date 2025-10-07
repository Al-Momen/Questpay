<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use App\Constants\Status;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $search = $request->get('search');
        $query = Plan::latest();
        switch ($status) {
            case 'disable':
                $query->where('status', Status::PLAN_DISABLE);
                break;
            case 'enable':
                $query->where('status', Status::PLAN_ENABLE);
                break;
            case 'all':
                $query->whereIn('status', [Status::PLAN_ENABLE, Status::PLAN_DISABLE]);
                break;
            default:
                break;
        }
        if ($search) {
            $query->searchable(['name']);
        }
        $plans = $query->paginate(getPaginate());
        $pageTitle = ucfirst($status) . ' plans';
        return view('Admin::plan.index', compact('plans', 'pageTitle'));
    }

    public function create()
    {
        $pageTitle = 'Create New Plan';
        return view('Admin::plan.create', compact('pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'icon' => ['required', 'string', 'regex:/^<i class=\"[a-z0-9\- ]+\"><\/i>$/i'],
            'name' => ['required', 'string', 'max:255', 'unique:plans,name'],
            'price' => ['required', 'numeric', 'min:0'],
            'features' => ['required', 'array', 'min:1'],
            'features.*' => ['required', 'string', 'max:255'],
        ]);

        $plan = new Plan();
        $plan->icon = $request->icon;
        $plan->name = $request->name;
        $plan->price = $request->price;
        $plan->features = $request->features;
        $plan->save();
        $notify[] = ['success', 'Plan has been created successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {

        $plan = Plan::where('id', $id)->first();
        if (!$plan) {
            $notify[] = ['error', 'Plan not found'];
            return back()->withNotify($notify);
        }

        $request->validate([
            'icon' => 'required|string|regex:/^<i class="[^"]+"><\/i>$/i',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('plans')->ignore($id),
            ],
            'price' => 'required|numeric|min:0',
            'features' => 'required|array|min:1',
            'features.*' => 'required|string|max:255',
        ]);

        $plan->icon = $request->icon;
        $plan->name = $request->name;
        $plan->price = $request->price;
        $plan->features = $request->features;
        $plan->save();

        $notify[] = ['success', 'Plan has been Updated successfully'];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        $plan = Plan::where('id', $id)->first();
        if (!$plan) {
            $notify[] = ['error', 'Plan not found'];
            return back()->withNotify($notify);
        }
        $plan->status = $plan->status == 1 ? 0 : 1;
        $plan->save();
        $notify[] = ['success', 'Plan Status has been updated successfully'];
        return back()->withNotify($notify);
    }
}
