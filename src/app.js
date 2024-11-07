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

databaseConnection()






app.post('/test', (req, res) => {
    const {email , password} = req.body


    return res.json({message  : `This is email : ${email} and this is password : ${password}`})
})


app.listen(process.env.PORT || 3000, () => { 
    console.log(`Server is running on port http://${process.env.HOST}:${process.env.PORT || 3000}`)
})
