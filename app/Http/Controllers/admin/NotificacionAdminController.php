<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notificacion;

class NotificacionAdminController extends Controller
{
    public function marcarLeida($id)
    {
        $noti = Notificacion::findOrFail($id);
        $noti->leida = true;
        $noti->save();
        // Devolver el nuevo conteo de no leídas
        $notiCount = Notificacion::where('leida', false)->count();
        return response()->json(['success' => true, 'notiCount' => $notiCount]);
    }
    
    public function marcarTodasLeidas()
    {
        Notificacion::where('leida', false)->update(['leida' => true]);
        return response()->json(['success' => true]);
    }

    public function eliminar($id)
    {
        $noti = Notificacion::findOrFail($id);
        $noti->delete();
        $notiCount = Notificacion::where('leida', false)->count();
        return response()->json(['success' => true, 'notiCount' => $notiCount]);
    }
}
