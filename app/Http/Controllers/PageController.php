<?php

namespace App\Http\Controllers;

use App\Models\PageGroup;
use App\Http\Requests\Page\StoreRequest;
use App\Models\Page;

class PageController extends Controller
{

    public function index() {
        $pages = Page::paginated(
            \request()->user(),
            Page::PAGINATE,
            \request()->get('sort'),
            \request()->get('by')
        );
        return view('page.index', compact('pages'));
    }

    public function create() {
        $groups = PageGroup::all();
        return view('page.create', compact('groups'));
    }

    public function store(StoreRequest $request) {
        $payload = $request->validated();
        $payload['is_visible'] = isset($payload['is_visible']);
        Page::create($payload);
        return to_route('page.index');
    }

    public function edit($id) {
        $groups = PageGroup::all();
        $page = Page::getByUserAndId(\request()->user(), $id);
        return view('page.edit', compact('page', 'groups'));
    }

    public function update(StoreRequest $request, $id) {
        $page = Page::getByUserAndId(\request()->user(), $id);
        $payload = $request->validated();
        $payload['is_visible'] = isset($payload['is_visible']);
        if(!isset($payload['roles'])) {
            $payload['roles'] = [];
        }
        $page->update($payload);
        return to_route('page.index');
    }

    public function delete($id) {
        $page = Page::getByUserAndId(\request()->user(), $id);
        $page->delete();
        return back();
    }

}
