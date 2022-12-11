<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NoteController extends Controller
{
    public function dashboard(Request $request) {
        $notes = Note::where('user_id', Auth::user()->id)
            ->where('title', 'LIKE', '%'.$request->search.'%')
            ->orWhere('content', 'LIKE', '%'.$request->search.'%')
            ->orderBy('created_at', 'DESC')
            ->paginate(3);
        return view('dashboard', compact('notes'));
    }

    public function create(Request $request) {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'color' => 'required',
        ],[
            'required' => 'O campo :attribute é obrigatório!'
        ]);

        $note = $request->except('_token');
        $note['user_id'] = Auth::user()->id;
        Note::create($note);

        return back()->with(['success' => 'Review criada com sucesso!']);
    }

    public function update(Request $request) {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'color' => 'required',
        ],[
            'required' => 'O campo :attribute é obrigatório!'
        ]);

        $note = $request->except('_token');

        Note::find($request->id)->update($note);

        return back()->with(['success' => 'Review editada com sucesso!']);
    }

    public function delete(Request $request) {
        // Excluir arquivos relacionados à Review
        $files = File::where('note_id', $request->id)->get();
        foreach ($files as $file) {
            if (Storage::exists($file->directory)) // Verificar se existe o arquivo
                Storage::delete($file->directory); // Excluir arquivo
        }

        Note::find($request->id)->delete();

        return back()->with(['success' => 'Review excluída com sucesso!']);
    }

    public function uploadFile(Request $request) {
        $request->validate([
            'id' => 'required | numeric | exists:notes,id',
            'file' => ['required', 'mimes:png,jpg,webp', 'max:1024']
        ],[
            'file.required' => 'Selecione um arquivo!',
            'file.mimes' => 'Os tipos de arquivo permitido é apenas png, jpg ou webp!',
        ]);

        $directory = $request->file->store('files');

        File::create(['note_id' => $request->id, 'directory' => $directory]);

        return back()->with(['success' => 'Imagem salva com sucesso!']);
    }

    public function deleteFile(Request $request) {
        $file = File::find($request->id);

        if (Storage::exists($file->directory)) // Verificar se existe o Imagem
            Storage::delete($file->directory); // Excluir Imagem

        // Ecluir dados na tabela
        $file->delete();

        return back()->with(['success' => 'Imagem excluída com sucesso!']);
    }

    public function downloadFile(Request $request) {
        $file = File::find($request->id);

        return Storage::download($file->directory);
    }
}
