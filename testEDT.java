import java.util.ArrayList;
import java.util.Collections;
import java.util.Random;

public class testEDT {

        public static void main(String[] args) {
            int nbJours = 5;
            int nbCreneaux = 4;
            int nbSalles = 3;
            int nbCours = 10;

            int[][][] contraintesCours = new int[nbCours][nbJours][nbCreneaux];
            int[][][] contraintesSalle = new int[nbCours][nbJours][nbCreneaux];
            // remplir les tableaux de contraintes avec des valeurs arbitraires

            Emploidutemps emploiDuTemps = new Emploidutemps(nbJours, nbCreneaux, nbSalles, nbCours,
                    contraintesCours, contraintesSalle);

            emploiDuTemps.initialiserEmploiDuTemps();

            System.out.println("Emploi du temps initial :");
            afficherEmploiDuTemps(emploiDuTemps.getEmploiDuTemps());
            System.out.println("Nombre total de violations : " + emploiDuTemps.getNbViolations()[nbCours]);
        }

        public static void afficherEmploiDuTemps(int[][] emploiDuTemps) {
            for (int i = 0; i < emploiDuTemps.length; i++) {
                for (int j = 0; j < emploiDuTemps[0].length; j++) {
                    System.out.print(emploiDuTemps[i][j] + " ");
                }
                System.out.println();
            }
        }
    }
