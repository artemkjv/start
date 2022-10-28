<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageGroup\StoreRequest;
use App\Models\PageGroup;

class PageGroupController extends Controller
{

    public function index() {
        $groups = PageGroup::paginated();
        return view('page-group.index', compact('groups'));
    }

    public function store(StoreRequest $request) {
        $payload = $request->validated();
        PageGroup::create($payload);
        return back();
    }

    public function edit($id) {
        $pageGroup = PageGroup::getById($id);
        return view('page-group.edit', compact('pageGroup'));
    }

    public function update(StoreRequest $request, $id) {
        $payload = $request->validated();
        $pageGroup = PageGroup::getById($id);
        $pageGroup->update($payload);
        return to_route('page-groups.index');
    }

    public function destroy($id) {
        PageGroup::destroy($id);
        return back();
    }

}
