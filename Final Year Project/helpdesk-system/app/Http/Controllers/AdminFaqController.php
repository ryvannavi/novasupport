<?php
namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class AdminFaqController extends Controller
{
    private function categories() {
        return ['getting-started','authentication','billing','advanced-settings','technical-issues','analytics'];
    }

    public function index()
    {
        $faqs = Faq::orderBy('category')->orderBy('order')->get();
        if (request()->has('ajax')) return view('admin.faq', compact('faqs'))->render();
        return view('admin.faq', compact('faqs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|in:'.implode(',',$this->categories()),
            'question' => 'required|string|max:300',
            'answer'   => 'required|string|max:2000',
        ]);
        $validated['order'] = Faq::where('category',$validated['category'])->max('order') + 1;
        Faq::create($validated);
        return redirect()->route('admin.faq.index')->with('success','FAQ article added!');
    }

    public function destroy($id)
    {
        Faq::findOrFail($id)->delete();
        return redirect()->route('admin.faq.index')->with('success','FAQ article deleted!');
    }
}