#include "mainwindow.h"
#include "ui_mainwindow.h"
#include "smtp.h"
#include <QSql>
#include <QSqlQuery>
#include <QSqlDatabase>
#include <QDebug>
#include <QMessageBox>

//QSqlResult fetch(QString table, QString selection, QString option);

MainWindow::MainWindow(QWidget *parent) :
    QMainWindow(parent),
    ui(new Ui::MainWindow)
{
    ui->setupUi(this);
    m_compteur = new QTimer(this);
    //m_thread_timer = new QThread();
    //m_compteur->moveToThread(m_thread_timer);
    m_compteur->start(60000);         // 1 minute
    //m_compteur->start(86400000);    // 24h (ms)
    //connect(m_thread_timer, &QThread::started, m_compteur, &QTimer::isActive);
    //connect(m_compteur, &QTimer::stop, m_thread_timer, &QThread::quit);
    //connect(m_thread_timer, &QThread::finished, m_thread_timer, &QThread::deleteLater);
    connect(m_compteur, SIGNAL(timeout()), this, SLOT(mise_a_jour_heure()));
    //m_thread_timer->start();
    m_heure = new QTime();
    *m_heure = QTime::currentTime();
    m_heure_texte = new QString();
    *m_heure_texte = m_heure->toString("hh : mm");
    connect(this, SIGNAL(time_updated()), this, SLOT(alerter()));
}

MainWindow::~MainWindow()
{
    delete ui;
}

void MainWindow::mise_a_jour_heure()
{
    *m_heure = QTime::currentTime();
    *m_heure_texte =m_heure->toString("hh : mm");
    qDebug() << "heure actuelle : " << *m_heure_texte;
    emit time_updated();
}

void MainWindow::on_pushButtonEnvoyer_clicked()
{
    // Connexion à la base de donnée
    QSqlDatabase db = QSqlDatabase::addDatabase("QMYSQL");
    //db.setHostName("192.168.2.205");
    //db.setHostName("172.16.172.15");
    db.setHostName("127.0.0.1");
    db.setPort(3306);
    db.setUserName("root");
    db.setPassword("raspberry");
    db.setDatabaseName("e-vegetal");

    if(db.open())
        qDebug() << "connexion réussi !";
    else
        qDebug() << "erreur : impossible de se connecter à la base de donnée";

    QSqlQuery req_co2, req_date, req_humidite_sol, req_humidite_air, req_luminosite,
            req_plantes, req_temperature;
    req_co2.prepare("SELECT valeur_CO2 FROM `CO2` ORDER BY `ID_date` DESC");
    req_date.prepare("SELECT date FROM `Date` ORDER BY `date` DESC");
    req_humidite_air.prepare("SELECT valeur_humAir FROM `HumiditeAir` ORDER BY `ID_date` DESC");
    req_humidite_sol.prepare("SELECT valeur_humSol FROM `HumiditeSol` ORDER BY `ID_date` DESC");
    req_luminosite.prepare("SELECT valeur_lum FROM `Luminosite` ORDER BY `ID_date` DESC");
    //req_plantes.prepare("SELECT * FROM `Plantes` WHERE `date_retrait` IS NULL");
    req_temperature.prepare("SELECT valeur_temp FROM `Temperature` ORDER BY `ID_date` DESC");

    // compteur d'erreurs
    erreurs = 0;

    if(req_co2.exec()) {
        // if au lieu de while : pour récupérer seulement la valeur la plus réçente
        if(req_co2.next()) {
            qDebug() << "requete CO2 ok";
            float co2 = req_co2.value(0).toFloat();
            qDebug() << co2 << "ppm";
        }
    } else
        qDebug() << "erreur requete CO2";

    if(req_date.exec()) {
        if(req_date.next()) {
            qDebug() << "requete Date ok";
            QString date = req_date.value(0).toString();
            qDebug() << date;
        }
    } else
        qDebug() << "erreur requete Date";

    if(req_humidite_air.exec()) {
        if(req_humidite_air.next()) {
            qDebug() << "requete humidite air ok";
            float humidite_air = req_humidite_air.value(0).toFloat();
            qDebug() << humidite_air << "% (air)";
            if(humidite_air >= 60 || humidite_air <= 10)
                erreurs++;
        }
    } else
        qDebug() << "erreur requete humidite air";

    if(req_humidite_sol.exec()) {
        if(req_humidite_sol.next()) {
            qDebug() << "requete humidite sol ok";
            float humidite_sol = req_humidite_sol.value(0).toFloat();
            qDebug() << humidite_sol << "%(sol)";
            if(humidite_sol <= 10)
                erreurs++;
        }
    } else
        qDebug() << "erreur requete humidite sol";

    if(req_luminosite.exec()) {
        if(req_luminosite.next()) {
            qDebug() << "requete luminosite ok";
            float luminosite = req_luminosite.value(0).toFloat();
            qDebug() << luminosite << "lux";
            if(luminosite < 500)
                erreurs++;
        }
    } else
        qDebug() << "erreur requete luminosite";

    /*if(req_plantes.exec())
        qDebug() << "requete plantes ok";
    else
        qDebug() << "erreur requete plantes";
    */

    qDebug() << "avant température";
    if(req_temperature.exec()) {
        if(req_temperature.next()) {
            qDebug() << "requete temperature ok";
            float temperature = req_temperature.value(0).toFloat();
            qDebug() << temperature << "°C";
            if(temperature < 17 || temperature > 21)
                erreurs++;
        }
    } else
        qDebug() << "erreur requete temperature";
    qDebug() << "après température";

    if(erreurs != 0) {
        // conversion int vers QString
        QString compteur_erreurs = QString::number(erreurs);
        QString message = compteur_erreurs;
        if(compteur_erreurs == "1")
            message = "Un paramètre critique a été franchis, consultez votre interface !";
        else
            message += " paramètres critiques ont été franchis, consultez votre interface !";

        Smtp *email = new Smtp("suivi.vegetal2021", "TN2-GR1#123_", "smtp.gmail.com", 465, 30000);
        email->sendMail("suivi.vegetal2021@gmail.com",
                        "raphael.kliyanage@gmail.com",
                        "Alerte : consultez votre interface !",
                        message);
        QMessageBox confirmation;
        confirmation.setText(compteur_erreurs + " valeurs critiques ont été franchis. Un email d'alerte a été envoyé.");
        confirmation.exec();
    } else {
        QMessageBox confirmation1;
        confirmation1.setText("0 valeurs critiques ont été franchis. Aucun email d'alerte a été envoyé.");
        confirmation1.exec();
    }
}

void MainWindow::alerter()
{
    // Connexion à la base de donnée
    QSqlDatabase db = QSqlDatabase::addDatabase("QMYSQL");
    //db.setHostName("192.168.2.205");
    //db.setHostName("172.16.172.15");
    db.setHostName("127.0.0.1");
    db.setPort(3306);
    db.setUserName("root");
    db.setPassword("raspberry");
    db.setDatabaseName("e-vegetal");

    if(db.open())
        qDebug() << "connexion réussi !";
    else
        qDebug() << "erreur : impossible de se connecter à la base de donnée";

    QSqlQuery req_co2, req_date, req_humidite_sol, req_humidite_air, req_luminosite,
            req_plantes, req_temperature;
    req_co2.prepare("SELECT valeur_CO2 FROM `CO2` ORDER BY `ID_date` DESC");
    req_date.prepare("SELECT date FROM `Date` ORDER BY `date` DESC");
    req_humidite_air.prepare("SELECT valeur_humAir FROM `HumiditeAir` ORDER BY `ID_date` DESC");
    req_humidite_sol.prepare("SELECT valeur_humSol FROM `HumiditeSol` ORDER BY `ID_date` DESC");
    req_luminosite.prepare("SELECT valeur_lum FROM `Luminosite` ORDER BY `ID_date` DESC");
    //req_plantes.prepare("SELECT * FROM `Plantes` WHERE `date_retrait` IS NULL");
    req_temperature.prepare("SELECT valeur_temp FROM `Temperature` ORDER BY `ID_date` DESC");

    // compteur d'erreurs
    erreurs = 0;

    if(req_co2.exec()) {
        // if au lieu de while : pour récupérer seulement la valeur la plus réçente
        if(req_co2.next()) {
            qDebug() << "requete CO2 ok";
            float co2 = req_co2.value(0).toFloat();
            qDebug() << co2 << "ppm";
        }
    } else
        qDebug() << "erreur requete CO2";

    if(req_date.exec()) {
        if(req_date.next()) {
            qDebug() << "requete Date ok";
            QString date = req_date.value(0).toString();
            qDebug() << date;
        }
    } else
        qDebug() << "erreur requete Date";

    if(req_humidite_air.exec()) {
        if(req_humidite_air.next()) {
            qDebug() << "requete humidite air ok";
            float humidite_air = req_humidite_air.value(0).toFloat();
            qDebug() << humidite_air << "% (air)";
            if(humidite_air >= 60 || humidite_air <= 10)
                erreurs++;
        }
    } else
        qDebug() << "erreur requete humidite air";

    if(req_humidite_sol.exec()) {
        if(req_humidite_sol.next()) {
            qDebug() << "requete humidite sol ok";
            float humidite_sol = req_humidite_sol.value(0).toFloat();
            qDebug() << humidite_sol << "%(sol)";
            if(humidite_sol <= 20)
                erreurs++;
        }
    } else
        qDebug() << "erreur requete humidite sol";

    if(req_luminosite.exec()) {
        if(req_luminosite.next()) {
            qDebug() << "requete luminosite ok";
            float luminosite = req_luminosite.value(0).toFloat();
            qDebug() << luminosite << "lux";
            if(luminosite < 500)
                erreurs++;
        }
    } else
        qDebug() << "erreur requete luminosite";

    /*if(req_plantes.exec())
        qDebug() << "requete plantes ok";
    else
        qDebug() << "erreur requete plantes";
    */

    if(req_temperature.exec()) {
        if(req_temperature.next()) {
            qDebug() << "requete temperature ok";
            float temperature = req_temperature.value(0).toFloat();
            qDebug() << temperature << "°C";
            if(temperature < 17 || temperature > 21)
                erreurs++;
        }
    } else
        qDebug() << "erreur requete temperature";

    qDebug() << "heure actuelle, mais genre dans le slot : " << *m_heure_texte;

    if(erreurs != 0 && *m_heure_texte == "12 : 00") {
        // conversion int vers QString
        QString compteur_erreurs = QString::number(erreurs);
        QString message = compteur_erreurs;
        if(compteur_erreurs == "1")
            message = "Un paramètre critique a été franchis, consultez votre interface !";
        else
            message += " paramètres critiques ont été franchis, consultez votre interface !";

        Smtp *email = new Smtp("suivi.vegetal2021", "TN2-GR1#123_", "smtp.gmail.com", 465, 30000);
        email->sendMail("suivi.vegetal2021@gmail.com",
                        "raphael.kliyanage@gmail.com",
                        "Alerte : consultez votre interface !",
                        message);
        /* Le message box empeche l'envoi d'un second message si on n'appuie pas sur Ok
         * QMessageBox confirmation;
        confirmation.setText(compteur_erreurs + " valeurs critiques ont été franchis. Un email d'alerte a été envoyé.");
        confirmation.exec();*/
    }
}

/*
 * Début d'une fonction équivalente fetch_assoc
 *
 * QSqlResult fetch(QString table, QString selection, QString option) {
    QSqlQuery requete;
    requete.prepare("SELECT " + selection + " FROM " + table + " " + option);
    if(!requete.exec())
        qDebug() << "erreur lors de l'envoi de la requete";

    return requete;
}
*/
