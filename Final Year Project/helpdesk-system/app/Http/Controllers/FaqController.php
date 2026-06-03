<?php
namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    private function categoryMeta() {
        return [
            'getting-started'   => ['label'=>'Getting Started',        'icon'=>'fa-rocket',            'color'=>'#7c3aed', 'bg'=>'linear-gradient(135deg,#ede9fe,#ddd6fe)', 'badge'=>'New',  'badgeStyle'=>'background:#dcfce7;color:#15803d;'],
            'authentication'    => ['label'=>'Authentication & Security','icon'=>'fa-shield-halved',     'color'=>'#db2777', 'bg'=>'linear-gradient(135deg,#fce7f3,#fbcfe8)', 'badge'=>null,   'badgeStyle'=>''],
            'billing'           => ['label'=>'Billing & Pricing',       'icon'=>'fa-credit-card',       'color'=>'#ca8a04', 'bg'=>'linear-gradient(135deg,#fef9c3,#fde68a)', 'badge'=>null,   'badgeStyle'=>''],
            'advanced-settings' => ['label'=>'Advanced Settings',       'icon'=>'fa-gear',              'color'=>'#0891b2', 'bg'=>'linear-gradient(135deg,#e0f2fe,#bae6fd)', 'badge'=>null,   'badgeStyle'=>''],
            'technical-issues'  => ['label'=>'Technical Issues',        'icon'=>'fa-screwdriver-wrench','color'=>'#16a34a', 'bg'=>'linear-gradient(135deg,#dcfce7,#bbf7d0)', 'badge'=>'Hot',  'badgeStyle'=>'background:#fee2e2;color:#dc2626;'],
            'analytics'         => ['label'=>'Analytics & Reports',     'icon'=>'fa-chart-line',        'color'=>'#0891b2', 'bg'=>'linear-gradient(135deg,#ecfeff,#a5f3fc)', 'badge'=>null,   'badgeStyle'=>''],
        ];
    }

    public function index()
    {
        $categories = $this->categoryMeta();
        $counts = Faq::selectRaw('category, count(*) as total')->groupBy('category')->pluck('total','category');

        if (request()->has('ajax')) {
            return view('faq.index', compact('categories','counts'))->render();
        }
        return view('faq.index', compact('categories','counts'));
    }

    public function category($slug)
    {
        $categories = $this->categoryMeta();
        if (!isset($categories[$slug])) abort(404);

        $meta = $categories[$slug];
        $faqs = Faq::where('category', $slug)->orderBy('order')->get();

        // Related: other categories
        $related = collect($categories)->except($slug)->take(3);

        if (request()->has('ajax')) {
            return view('faq.category', compact('meta','faqs','related','slug','categories'))->render();
        }
        return view('faq.category', compact('meta','faqs','related','slug','categories'));
    }

    public function search(Request $request)
    {
        $q = $request->get('q','');
        $results = Faq::where('question','like',"%$q%")
            ->orWhere('answer','like',"%$q%")
            ->orderBy('category')->get();
        return response()->json($results);
    }
}