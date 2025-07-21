<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\Stand;
use Illuminate\Support\Facades\Storage;

class EntrepreneurDashboardController extends Controller
{
    // Middleware is handled in routes/web.php

    /**
     * Show the entrepreneur dashboard
     */
    public function index()
    {
        $entrepreneur = Auth::guard('entrepreneur')->user();
        $stand = Stand::where('utilisateur_id', $entrepreneur->id)->first();
        $products = $stand ? $stand->products()->latest()->get() : collect();
        $totalProducts = $products->count();
        $recentProducts = $products->take(5); // Show 5 most recent
        // Orders logic can be added similarly
        $data = [
            'entrepreneur' => $entrepreneur,
            'totalProducts' => $totalProducts,
            'totalOrders' => 0, // Update with real order count if needed
            'pendingOrders' => 0, // Update with real pending order count if needed
            'recentProducts' => $recentProducts,
        ];
        return view('entrepreneur.dashboard', $data);
    }

    /**
     * Show product management page
     */
    public function products()
    {
        $entrepreneur = Auth::guard('entrepreneur')->user();
        $stand = Stand::where('utilisateur_id', $entrepreneur->id)->first();
        $products = $stand ? $stand->products : collect();
        return view('entrepreneur.products', compact('entrepreneur', 'products'));
    }

    /**
     * Store a new product
     */
    public function storeProduct(Request $request)
    {
        $entrepreneur = Auth::guard('entrepreneur')->user();
        $stand = Stand::where('utilisateur_id', $entrepreneur->id)->first();
        if (!$stand) {
            return redirect()->back()->with('error', 'Vous n\'avez pas de stand.');
        }
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = $request->file('image')->store('products', 'public');
        $product = $stand->products()->create([
            'nom' => $validated['nom'],
            'description' => $validated['description'],
            'prix' => $validated['prix'],
            'image_url' => $imagePath,
        ]);
        return redirect()->route('entrepreneur.products')->with('success', 'Produit ajouté avec succès !');
    }

    /**
     * Show the form for editing a product
     */
    public function editProduct($id)
    {
        $entrepreneur = Auth::guard('entrepreneur')->user();
        $stand = Stand::where('utilisateur_id', $entrepreneur->id)->first();
        $product = $stand ? $stand->products()->findOrFail($id) : null;
        if (!$product) {
            return redirect()->route('entrepreneur.products')->with('error', 'Product not found.');
        }
        return view('entrepreneur.edit_product', compact('entrepreneur', 'product'));
    }

    /**
     * Update a product
     */
    public function updateProduct(Request $request, $id)
    {
        $entrepreneur = Auth::guard('entrepreneur')->user();
        $stand = Stand::where('utilisateur_id', $entrepreneur->id)->first();
        $product = $stand ? $stand->products()->findOrFail($id) : null;
        if (!$product) {
            return redirect()->route('entrepreneur.products')->with('error', 'Produit introuvable.');
        }
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('image')) {
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image_url = $imagePath;
        }
        $product->nom = $validated['nom'];
        $product->description = $validated['description'];
        $product->prix = $validated['prix'];
        $product->save();
        return redirect()->route('entrepreneur.products')->with('success', 'Produit mis à jour avec succès !');
    }

    /**
     * Delete a product
     */
    public function deleteProduct($id)
    {
        $entrepreneur = Auth::guard('entrepreneur')->user();
        $stand = Stand::where('utilisateur_id', $entrepreneur->id)->first();
        $product = $stand ? $stand->products()->findOrFail($id) : null;
        if (!$product) {
            return redirect()->route('entrepreneur.products')->with('error', 'Product not found.');
        }
        if ($product->image_url) {
            Storage::disk('public')->delete($product->image_url);
        }
        $product->delete();
        return redirect()->route('entrepreneur.products')->with('success', 'Product deleted successfully!');
    }

    /**
     * Show order consultation page
     */
    public function orders(Request $request)
    {
        $entrepreneur = Auth::guard('entrepreneur')->user();
        $stand = Stand::where('utilisateur_id', $entrepreneur->id)->first();
        $orders = $stand ? $stand->orders()->latest()->get() : collect();
        // Optionally filter by status if implemented later
        return view('entrepreneur.orders', compact('entrepreneur', 'orders'));
    }
}
