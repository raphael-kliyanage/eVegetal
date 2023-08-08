#ifndef MAINWINDOW_H
#define MAINWINDOW_H

#include <QMainWindow>
#include <QTimer>
#include <QString>
#include <QThread>
#include <QDateTime>

namespace Ui {
class MainWindow;
}

class MainWindow : public QMainWindow
{
    Q_OBJECT

public:
    explicit MainWindow(QWidget *parent = nullptr);
    ~MainWindow();

private slots:
    void on_pushButtonEnvoyer_clicked();
    void alerter();
    void mise_a_jour_heure();
    //void on_pushButtonEnvoyerManuel_clicked();

signals:
    void time_updated();

private:
    Ui::MainWindow *ui;
    QTimer *m_compteur;    // attendre 24h (limitation envoi email) edit: 1 minute
    //QThread *m_thread_timer;
    int erreurs;
    QString *m_intervalle_jour;
    QString *m_intervalle_heure;
    QString *m_heure_texte;
    QTime *m_heure;  // comparer le temps
};

#endif // MAINWINDOW_H
