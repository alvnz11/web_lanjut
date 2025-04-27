<?php // Tag pembuka PHP

namespace App\Http\Controllers; // Mendeklarasikan namespace untuk Controller

use App\Models\Item; // import model Item
use Illuminate\Http\Request; // import class Request dari Laravel

class ItemController extends Controller // Mendeklarasikan kelas ItemController yang meng-extend Controller
{
    public function index() // Method untuk menampilkan daftar item
    {
        $items = Item::all(); // Mengambil semua data item dari database
        return view('items.index', compact('items')); // Mengembalikan tampilan 'items.index' dengan data items
    }

    public function create() // Method untuk menampilkan form tambah item
    {
        return view('items.create'); // Mengembalikan tampilan 'items.create'
    }

    public function store(Request $request) // Method untuk menyimpan data item baru
    {
        $request->validate([ // Validasi input dari request
            'name' => 'required', // Name harus diisi
            'description' => 'required', // Description harus diisi
        ]);
         
        // Item::create($request->all());
        // return redirect()->route('items.index'); 

        // Hanya masukkan atribut yang diizinkan
        Item::create($request->only(['name', 'description'])); // Menyimpan hanya atribut name dan description
        return redirect()->route('items.index')->with('success', 'Item added successfully.'); // Redirect dengan pesan sukses
    }

    public function show(Item $item) // Method untuk menampilkan detail item tertentu
    {
        return view('items.show', compact('item')); // Mengembalikan tampilan 'items.show' dengan data item
    }

    public function edit(Item $item) // Method untuk menampilkan form edit item tertentu
    {
        return view('items.edit', compact('item')); // Mengembalikan tampilan 'items.edit' dengan data item
    }

    public function update(Request $request, Item $item) // Method untuk memperbarui data item tertentu
    {
        $request->validate([ // Validasi input dari request
            'name' => 'required', // Name harus diisi
            'description' => 'required', // Description harus diisi
        ]);
         
        // $item->update($request->all()); 
        // return redirect()->route('items.index'); 

        // Hanya masukkan atribut yang diizinkan
        $item->update($request->only(['name', 'description'])); // Memperbarui hanya atribut name dan description
        return redirect()->route('items.index')->with('success', 'Item updated successfully.'); // Redirect dengan pesan sukses
    }

    public function destroy(Item $item) // Method untuk menghapus item tertentu
    {
        // return redirect()->route('items.index'); 
        $item->delete(); // Menghapus item dari database
        return redirect()->route('items.index')->with('success', 'Item deleted successfully.'); // Redirect dengan pesan sukses
    }
}