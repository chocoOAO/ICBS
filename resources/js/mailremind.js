// 引入 Nodemailer 模組
const nodemailer = require('nodemailer');
const mysql = require('mysql');
const { result } = require('lodash');

// 本地DB測試
const connection = mysql.createConnection({
    host: '127.0.0.1',
    user: 'root',
    password: '',
    database: 'fms',
});

// 連線至主機端DB
// const connection = mysql.createConnection({
//     host: '127.0.0.1',
//     user: 'fwusow',
//     password: 'fwusow123456',
//     database: 'fwusow',
// });

connection.connect();

// 執行 SQL 查詢
const mailquery = "SELECT email FROM users WHERE auth_type != 'worker'";
const cnumquery = "SELECT contracts.m_KUNAG FROM contracts INNER JOIN chicken_imports ON contracts.id = chicken_imports.contract_id";
const batchnumquery = "SELECT id FROM chicken_imports";

connection.query(mailquery, function (error, results1, fields) {
    if (error) {
        console.log('EMAIL查詢錯誤: ' + error);
    } else {
        // 處理第一個查詢結果
        const emails = results1.map(result => result.email);

        console.log("Email:",emails);

        // 執行第二個查詢
        connection.query(cnumquery, function (error, results2, fields) {
            if (error) {
                console.log('客戶代號查詢錯誤: ' + error);
            } else {

                // 執行第三個查詢
                connection.query(batchnumquery, function (error, results3, fields) {
                    if (error) {
                        console.log('批號查詢錯誤: '+ error);
                    } else {

                        //郵件主旨設定
                        results2.forEach(result => {
                            const m_KUNAG = result.m_KUNAG;
                            const id = results3[0].id;

                            const mail_subject = '客戶編號' + m_KUNAG + ' 批號' + id + ' 入雛表填寫提醒';

                            console.log("m_KUNAG:",mail_subject);

                            // 建立一個 Nodemailer 傳輸物件
                            const transporter = nodemailer.createTransport({
                                service: 'Gmail',
                                auth: {
                                    user: 'yuchen.yang.704@gmail.com',
                                    pass: 'sozg dytf xval lajs',
                                }
                            });

                            //針對每個EMAIL發送提醒郵件
                            emails.forEach(email => {
                                const mailOptions = {
                                    from: 'yuchen.yang.704@gmail.com',
                                    to: email,
                                    subject: mail_subject,
                                    text: '您已經超過三天未填寫入雛表，請盡快填寫完成各項欄位。',
                                };

                                transporter.sendMail(mailOptions, (error, info) => {
                                    if (error) {
                                        console.log('郵件寄送失敗 ' + email + ': ' + error);
                                    } else {
                                        console.log('郵件寄送成功 ' + email + ': ' + info.response);
                                    }
                                });
                            });
                        });
                    }
                });
                connection.end();
            }
        });
    }
});
