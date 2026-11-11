<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(): View
    {
        $programs = Program::query()
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->get();

        return view('programs.index', compact('programs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:120'],
            'deskripsi' => ['required', 'string', 'max:2000'],
        ]);

        Program::create($validated);

        return redirect()
            ->route('programs.index')
            ->with('status', 'Program berhasil ditambahkan.');
    }

    public function edit(Program $program): View
    {
        return view('programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:120'],
            'deskripsi' => ['required', 'string', 'max:2000'],
        ]);

        $program->update($validated);

        return redirect()
            ->route('programs.index')
            ->with('status', 'Program berhasil diperbarui.');
    }

    public function destroy(Program $program): RedirectResponse
    {
        $program->delete();

        return redirect()
            ->route('programs.index')
            ->with('status', 'Program berhasil dihapus.');
    }
}
