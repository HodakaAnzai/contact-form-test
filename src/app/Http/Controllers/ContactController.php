<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('contact', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->only([
            'first_name',
            'last_name',
            'gender',
            'email',
            'tel1',
            'tel2',
            'tel3',
            'address',
            'building',
            'category_id',
            'detail'
        ]);
        $category = Category::find($request->category_id);
        return view('confirm', compact('contact', 'category'));
    }

    public function store(Request $request)
    {

        if ($request->has('back')) {
            return redirect('/')->withInput();
        }

        $contact = $request->only([
            'last_name',
            'first_name',
            'gender',
            'email',
            'tel',
            'address',
            'building',
            'category_id',
            'detail'
        ]);
        Contact::create($contact);
        return view('thanks');
    }

    public function admin()
    {
        $contacts = Contact::with('category')->paginate(7);
        $categories = Category::all();
        return view('admin', compact('contacts', 'categories'));
    }

    public function delete(Request $request)
    {
        $contact = Contact::find($request->id)->delete();
        return redirect('/admin');
    }

    public function search(Request $request)
    {

        $searchConditions = [
            'word' => $request->word,
            'gender' => $request->gender,
            'category_id' => $request->category_id,
            'date' => $request->date,
        ];

        $contacts = Contact::with('category')->contactSearch($request)->paginate(7);
        $categories = Category::all();
        return view('admin', compact('contacts', 'categories', 'searchConditions'));
    }

    public function reset()
    {
        return redirect('/admin')->withInput();
    }

    public function export(Request $request)
    {
        $hasSearchConditions = $request->hasAny(['word', 'gender', 'category_id', 'date']) &&
            ($request->word || $request->gender || $request->category_id || $request->date);

        $contacts = $hasSearchConditions
            ? Contact::with('category')->contactSearch($request)->get()
            : Contact::with('category')->get();

        $csvHeader = [
            'Id',
            'カテゴリー',
            '姓',
            '名',
            '性別',
            'メールアドレス',
            '電話番号',
            '住所',
            '建物名',
            'お問い合わせ内容',
            '作成日時'
        ];

        $response = new StreamedResponse(function () use ($csvHeader, $contacts) {
            $handle = fopen('php://output', 'w');

            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, $csvHeader);

            foreach ($contacts as $contact) {
                fputcsv($handle, [
                    $contact->id,
                    $contact->category->content,
                    $contact->last_name,
                    $contact->first_name,
                    $contact->gender,
                    $contact->email,
                    $contact->tel,
                    $contact->address,
                    $contact->building,
                    $contact->detail,
                    $contact->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="Contact.csv"',
        ]);

        return $response;
    }
}
