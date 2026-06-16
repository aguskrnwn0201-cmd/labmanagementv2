let sock
const {
    default: makeWASocket,
    useMultiFileAuthState,
    DisconnectReason
} = require('@whiskeysockets/baileys')

const qrcode = require('qrcode-terminal')

async function startBot() {


    const { state, saveCreds } =
        await useMultiFileAuthState('session')

    sock = makeWASocket({
        auth: state
    })

    sock.ev.on(
        'creds.update',
        saveCreds
    )

    sock.ev.on(
        'connection.update',
        ({ connection, qr, lastDisconnect }) => {

            if (qr) {

                console.log('\nSCAN QR INI:\n')

                qrcode.generate(
                    qr,
                    { small: true }
                )
            }

            if (connection === 'open') {

                console.log(
                    '✅ WhatsApp Connected'
                )
            }

            if (connection === 'close') {

                const shouldReconnect =
                    lastDisconnect?.error?.output?.statusCode !==
                    DisconnectReason.loggedOut

                console.log(
                    '❌ Connection Closed'
                )

                if (shouldReconnect) {
                    startBot()
                }
            }
        }
    )

    const express = require('express')

    const app = express()

    app.use(express.json())

    app.post('/send-message', async (req, res) => {

        try {

            const { number, message } = req.body

            await sock.sendMessage(
                number + '@s.whatsapp.net',
                {
                    text: message
                }
            )

            return res.json({
                success: true
            })

        } catch (err) {

            console.error(err)

            return res.status(500).json({
                success: false
            })
        }

    })

    app.listen(3001, '0.0.0.0', () => {

        console.log(
            '🚀 WA Gateway Running :3001'
        )

    })


}

startBot()
