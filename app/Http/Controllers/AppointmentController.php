<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Clients\Client;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('citas.calendar', compact('clients'));
    }

    public function getAppointments()
    {
        $appointments = Appointment::all()->map(function ($appointment) {
            return [
                'id' => $appointment->id,
                'title' => $appointment->name,
                'start' => $appointment->appointment_date,
                'color' => $appointment->appointment_date == date('Y-m-d') ? 'red' : 'blue', // Resaltar citas de hoy
                'extendedProps' => [
                    'client_id' => $appointment->client_id,
                    'name' => $appointment->name,
                    'vehicle_details' => $appointment->vehicle_details,
                    'notes' => $appointment->notes,
                    'phone' => $appointment->phone,
                    'estado' => $appointment->estado,
                ],
            ];
        });

        return response()->json($appointments);
    }

    public function store(Request $request)
    {
        $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'vehicle_details' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'phone' => 'nullable|string|max:15',
            'name' => 'required|string|max:255',
        ]);

        $appointmentDateTime = $request->input('appointment_date') . ' ' . $request->input('appointment_time');

        $data = $request->all();
        $data['appointment_date'] = $appointmentDateTime;

        if ($request->filled('client_id')) {
            $data['client_id'] = $request->input('client_id');
        } else {
            $data['client_id'] = null; // Permitir citas sin cliente
        }

        Appointment::create($data);

        return response()->json(['success' => true]);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'vehicle_details' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'phone' => 'nullable|string|max:15',
            'name' => 'required|string|max:255',
        ]);

        $appointmentDateTime = $request->input('appointment_date') . ' ' . $request->input('appointment_time');

        $data = $request->all();
        $data['appointment_date'] = $appointmentDateTime;

        if ($request->filled('client_id')) {
            $data['client_id'] = $request->input('client_id');
        } else {
            $data['client_id'] = null;
        }

        $appointment->update($data);

        return response()->json(['success' => true]);
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json(['success' => true]);
    }
}
