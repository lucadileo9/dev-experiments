import Admin from '@/app/models/Admin';
import connectDB from '@/app/utils/db';
import bcrypt from 'bcryptjs';
import jwt from 'jsonwebtoken';

const JWT_SECRET = process.env.JWT_SECRET || 'your_jwt_secret'; // Imposta una chiave segreta

export const POST = async (request: Request) => {
  await connectDB(); // Connetti al database

  const body = await request.json();
  const { email, password } = body;

  if (!email || !password) {
    return new Response('Campi mancanti', { status: 400 });
  }

  // Trova l'admin nel database
  const admin = await Admin.findOne({ email });
  if (!admin) {
    return new Response('Credenziali non valide', { status: 401 });
  }

  // Verifica la password
  const isPasswordValid = await bcrypt.compare(password, admin.password);
  if (!isPasswordValid) {
    return new Response('Credenziali non valide', { status: 401 });
  }

  // Genera un token JWT
  const token = jwt.sign({ id: admin._id }, JWT_SECRET, { expiresIn: '1h' });

  return Response.json({ token }, { status: 200 });
};