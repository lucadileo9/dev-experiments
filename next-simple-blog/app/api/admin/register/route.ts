import bcrypt from 'bcryptjs';
import Admin from '@/app/models/Admin';
import connectDB from '@/app/utils/db';
import { verifyToken } from '@/app/middleware/authMiddleware';

export const POST = async (request: Request) => {
  await connectDB(); // Connetti al database

  // Verifica il token JWT
  const cookieStore = request.headers.get('cookie');
  const token = cookieStore?.split('=')[1]; // Estrai il token dai cookie
  const admin = await verifyToken(token || '');
  if (!admin) {
    return new Response('Accesso negato', { status: 403 });
  }

  const body = await request.json();
  const { email, password } = body;

  if (!email || !password) {
    return new Response('Campi mancanti', { status: 400 });
  }

  // Verifica se l'email esiste già
  const existingAdmin = await Admin.findOne({ email });
  if (existingAdmin) {
    return new Response('Email già registrata', { status: 409 });
  }

  // Crittografa la password
  const hashedPassword = await bcrypt.hash(password, 10);

  // Crea il nuovo admin
  const newAdmin = new Admin({ email, password: hashedPassword });
  await newAdmin.save();

  return Response.json({ message: 'Nuovo admin creato con successo!' }, { status: 201 });
};