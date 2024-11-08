import express from 'express'
import 'dotenv/config'
import cors from 'cors'
import cookieParser from 'cookie-parser'
import { databaseConnection } from './config/mongoDB.js'



const app = express()
app.use(cors({
    origin: process.env.ORIGIN || '*',
    credentials : true
}))

app.use(express.json())
app.use(cookieParser())











app.listen(process.env.PORT || 3000, () => { 
    databaseConnection()
    console.log(`Server is running on port http://${process.env.HOST}:${process.env.PORT || 3000}`)
})
