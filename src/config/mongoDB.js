import mongoose from "mongoose";

// Connect to MongoDB coopal 
export const databaseConnection = async () =>{
  try {
    await mongoose.connect(`mongodb://localhost:27017/${process.env.DATABASE}`)

    console.log('Connected na coopal')
  } catch (error) {
     console.error('MongoDB connection error coopal:', err);
  }
}