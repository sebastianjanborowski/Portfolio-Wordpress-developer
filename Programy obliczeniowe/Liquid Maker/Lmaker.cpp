#include <iostream>
#include <cstdlib>
#include <cmath>
#include <vector>
using namespace std;
float docelowa_moc;
float liquid_ml = 0;
int ilosc_aromatow = 0;
float slodzik_ml = 0;
float chlodzik_ml = 0;
float suma_aromat = 0;
float procent;
float moc_shota;
int moc;
int slodzik, chlodzik;
bool jazda = true;
struct Aromat
{
    string nazwa;
    float stezenie;
    float ilosc_ml;
};
void zero_mocy(vector<Aromat>& aromaty, int slodzik, int chlodzik);
void ilosc_lix(vector<Aromat>& aromaty);
void ile_aromatow(vector<Aromat>& aromaty);
void vektor(vector<Aromat>& aromaty);
void slodzone(vector<Aromat>& aromaty);
void chlodzone(vector<Aromat>& aromaty);
void z_moca(vector<Aromat>& aromaty);
void podaj_moc(vector<Aromat>& aromaty);
void docelowa_moc_lix(vector<Aromat>& aromaty);
void obliczenia(vector<Aromat>& aromaty);
void wyswietlenie(vector<Aromat>& aromaty, float shota_ml, float baza_ml);
int main()
{
    vector<Aromat> aromaty;
    ilosc_lix(aromaty);
    return 0;
}
void zero_mocy(vector<Aromat>& aromaty, int slodzik, int chlodzik)
{
    if (slodzik == 1)
    {
        slodzik_ml = round(slodzik_ml * 2) / 2;
    }
    if (chlodzik == 1)
    {
        chlodzik_ml = round(chlodzik_ml * 2) / 2;
    }

    for (int i = 0; i < ilosc_aromatow; i++)
    {
        cout << aromaty[i].nazwa << ": " << aromaty[i].ilosc_ml << " ml" << endl;
        suma_aromat += round(aromaty[i].ilosc_ml * 2) / 2;
    }
    float baza_ml = liquid_ml - suma_aromat - slodzik_ml - chlodzik_ml;

    cout << "Ilosc slodzika do wlania: " << slodzik_ml << " ml" << endl;
    cout << "Ilosc chlodzika do wlania: " << chlodzik_ml << " ml" << endl;
    cout << "Ilosc bazy do wlania: " << baza_ml << " ml" << endl;

    float ml = slodzik_ml + chlodzik_ml + baza_ml + suma_aromat;

    cout << endl << ml << " ilosc w ml wszystkiego";
}

void ilosc_lix(vector<Aromat>& aromaty)
{
    while (true)
    {
        cout << "Podaj ilosc Liquidu w ml: ";
        cin >> liquid_ml;
        if (liquid_ml > 0)
        {
            break;
        }
        system("cls");
    }
    ile_aromatow(aromaty);
}

void ile_aromatow(vector<Aromat>& aromaty)
{
    while (true)
    {
        cout << "Ile aromatow chcesz dodac: ";
        cin >> ilosc_aromatow;
        if (ilosc_aromatow > 0)
        {
            break;
        }
        system("cls");
    }
    aromaty.resize(ilosc_aromatow);
    vektor(aromaty);
}

void vektor(vector<Aromat>& aromaty)
{
    for (int i = 0; i < ilosc_aromatow; i++)
    {
        cout << "Podaj nazwe aromatu " << i + 1 << ": ";
        cin >> aromaty[i].nazwa;
        system("cls");
        while(jazda)
        {
            cout << "Podaj stezenie aromatu " << i + 1 << " w %: ";
            cin >> aromaty[i].stezenie;
            if(aromaty[i].stezenie > 0)
            {
                jazda = false;
                system("cls");
            }
            system("cls");
        }

        jazda = true;
        while(jazda)
        {
            cout << "Podaj proporcje aromatu " << i + 1 << ": ";
            cin >> procent;
            if(procent > 0)
            {
                jazda = false;
                system("cls");
            }
            system("cls");
        }
        jazda = true;
        procent = procent / 10.00;
        aromaty[i].ilosc_ml = (((aromaty[i].stezenie / 100) * liquid_ml) * procent)/ilosc_aromatow;////
    }
    slodzone(aromaty);
}

void slodzone(vector<Aromat>& aromaty)
{
    while(true)
    {
        cout << "Czy dodajesz slodzik? (1 - Tak, 0 - Nie): ";
        cin >> slodzik;
        if((slodzik == 1) || (slodzik == 0))
        {
            system("cls");
            break;
        }
    }

    if (slodzik == 1)
    {
        while(true)
        {
            cout << "Podaj proporcje slodzika na 100ml" << endl;
            cin >> slodzik_ml;
            if(slodzik > 0)
            {
                break;
                system("cls");
            }
        }
        slodzik_ml = ((slodzik_ml / 100) * liquid_ml);
    }
    chlodzone(aromaty);
}

void chlodzone(vector<Aromat>& aromaty)
{
    while(true)
    {
        cout << "Czy dodajesz chlodzik? (1 - Tak, 0 - Nie): ";
        cin >> chlodzik;
        if((chlodzik == 1) || (chlodzik == 0))
        {
            system("cls");
            break;
        }
        system("cls");
    }

    if (chlodzik == 1)
    {
        while(true)
        {
            cout << "Podaj proporcje chlodzika na 100ml" << endl;
            cin >> chlodzik_ml;
            if(chlodzik_ml > 0)
            {
                system("cls");
                break;
            }
        }
        chlodzik_ml = ((chlodzik_ml / 100) * liquid_ml);
    }
    z_moca(aromaty); // Dodano argument
}

void z_moca(vector<Aromat>& aromaty)
{
    while(true)
    {
        cout << "Czy chcesz zrobic liquid z moca ?" << endl;
        cout << "1 - Tak || 2 - Nie ";
        cin >> moc;
        if((moc == 1) || (moc == 2))
        {
            system("cls");
            break;
        }
        system("cls");
    }

    if (moc == 2)
    {
        zero_mocy(aromaty, slodzik, chlodzik);
    }
    else
    {
        podaj_moc(aromaty);
    }
}

void podaj_moc(vector<Aromat>& aromaty)
{
    while(true)
    {
        cout << "Podaj moc Shota mg/ml: ";
        cin >> moc_shota;
        if(moc > 0)
        {
            system("cls");
            break;
        }
        system("cls");
    }
    docelowa_moc_lix(aromaty);
}

void docelowa_moc_lix(vector<Aromat>& aromaty)
{
    while(true)
    {
        cout << "Podaj docelowa moc mg/ml: ";
        cin >> docelowa_moc;
        if(docelowa_moc > 0)
        {
            system("cls");
            break;
        }
        system("cls");
    }
    obliczenia(aromaty);
}

void obliczenia(vector<Aromat>& aromaty)
{
    float shota_ml = (docelowa_moc / moc_shota) * liquid_ml;
    for (int i = 0; i < ilosc_aromatow; i++)
    {
        suma_aromat += aromaty[i].ilosc_ml;
    }
    float baza_ml = liquid_ml - shota_ml - suma_aromat - slodzik_ml - chlodzik_ml;
    wyswietlenie(aromaty, shota_ml, baza_ml);
}

void wyswietlenie(vector<Aromat>& aromaty, float shota_ml, float baza_ml)
{
    cout << "Sklad liquidu:" << endl;
    for (int i = 0; i < ilosc_aromatow; i++)
    {
        cout << aromaty[i].nazwa << ": " << aromaty[i].ilosc_ml << " ml" << endl;
    }
    cout << "Ilosc slodzika do wlania: " << slodzik_ml << " ml" << endl;
    cout << "Ilosc chlodzika do wlania: " << chlodzik_ml << " ml" << endl;
    cout << "Ilosc shota do wlania: " << shota_ml << " ml" << endl;
    cout << "Ilosc bazy do wlania: " << baza_ml << " ml" << endl;
    float ml = slodzik_ml + chlodzik_ml + shota_ml + baza_ml + suma_aromat;
    cout << endl << ml << " ilosc w ml wszystkiego";
}

