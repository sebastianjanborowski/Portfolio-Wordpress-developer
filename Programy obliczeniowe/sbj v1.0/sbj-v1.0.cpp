#include <iostream>
#include <string>
#include <cmath> // Poprawka: <math.h> na <cmath>
using namespace std;

string text = "";
char table_char[25];

void znak();
void textt();
void hashing(string text);

int main()
{
    znak();
    textt();
    hashing(text);
    return 0;
}

void znak()
{
    int pomoc = 0; // Poprawka: zmienna pomoc zdefiniowana lokalnie
    for(char c = 'a'; c <= 'z'; c++)
    {
        table_char[pomoc] = c;
        pomoc++;
    }
}

void textt()
{
    cout << "Podaj tekst do haszowania: ";
    getline(cin, text);
}

void hashing(string text)
{
    unsigned long long mind = 0;
    int zmienna = text.length();
    for(int i = 0; i < text.length(); i++)
    {
        char pojedynczy_znak = text[i];
        for(int j = 0; j < 3; j++)
        {
            if(j % 2 == 0)
            {
                for(int y = 0; y < 25; y++)
                {
                    if(pojedynczy_znak == table_char[y])
                    {
                        int help = y;
                        if(help % 2 == 0)
                        {
                            cout << table_char[help / 2];
                        }
                        else
                        {
                            if(help + 3 > 25)
                            {
                                help = (help + 3 - 25);
                                cout << table_char[help];
                            }
                            else
                            {
                                cout << table_char[help + 3];
                            }
                        }
                    }
                }
            }
            else
            {
                unsigned long long pomocna = 0; // Poprawka: zmienna pomocna zdefiniowana lokalnie
                if(i % 2 == 0)
                {
                    mind = pow(zmienna, text.length());
                    mind = mind - pow(zmienna, i);
                    mind = (mind * i) * text.length();
                    cout << mind;
                    zmienna--;
                }
                else if(i % 3 == 0)
                {
                    for(int iter = 0; iter < 25; iter++)
                    {
                        if(pojedynczy_znak == table_char[iter])
                        {
                            int help = iter;
                            if(help % 5 == 0)
                            {
                                cout << table_char[help / 3];
                            }
                            else
                            {
                                if(help + 5 > 25)
                                {
                                    help = (help + 5 - 25);
                                    cout << table_char[help];
                                }
                                else
                                {
                                    cout << table_char[help + 5];
                                }
                            }
                        }
                    }
                }
                else
                {
                    mind = pow(zmienna, text.length());
                    mind = mind - pow(i, zmienna);
                    mind = (mind * i) - pow(text.length(), zmienna);
                    cout << mind;
                    zmienna += 3;
                }
            }
        }
    }
}

