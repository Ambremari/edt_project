package planning_generation;
import java.util.ArrayList;
import java.util.Collections;
import java.util.Random;

public class Emploidutemps {

    public static final int MAX_NB_ITERATIONS_SANS_AMELIORATION = 1000000;
    private int nbJours ;
    private int nbCreneaux;
    private int nbSalles;
    private int nbCours;
    private int[][] emploiDuTemps;
    private int[][] meilleurEmploiDuTemps;
    private int[] nbViolations;
    private int[] meilleurNbViolations;
    private int[][][] contraintesCours;
    private int[][][] contraintesSalle;
    private Random rand;

    public Emploidutemps(int nbJours, int nbCreneaux, int nbSalles, int nbCours,
                         int[][][] contraintesCours, int[][][] contraintesSalle) {
        this.nbJours = nbJours;
        this.nbCreneaux = nbCreneaux;
        this.nbSalles = nbSalles;
        this.nbCours = nbCours;
        this.contraintesCours = contraintesCours;
        this.contraintesSalle = contraintesSalle;
        emploiDuTemps = new int[nbJours][nbCreneaux];
        meilleurEmploiDuTemps = new int[nbJours][nbCreneaux];
        nbViolations = new int[nbCours];
        meilleurNbViolations = new int[nbCours];
        rand = new Random();
    }

    public int[] getMeilleurNbViolations() {
        return meilleurNbViolations;
    }

    public int getNbCours() {
        return nbCours;
    }

    public int getNbCreneaux() {
        return nbCreneaux;
    }

    public int getNbJours() {
        return nbJours;
    }

    public int getNbSalles() {
        return nbSalles;
    }

    public int[][] getEmploiDuTemps() {
        return emploiDuTemps;
    }

    public int[] getNbViolations() {
        return nbViolations;
    }

    public int[][] getMeilleurEmploiDuTemps() {
        return meilleurEmploiDuTemps;
    }

    public int[][][] getContraintesCours() {
        return contraintesCours;
    }

    public int[][][] getContraintesSalle() {
        return contraintesSalle;
    }

    public static int getMaxNbIterationsSansAmelioration() {
        return MAX_NB_ITERATIONS_SANS_AMELIORATION;
    }

    public void initialiserEmploiDuTemps() {
        for (int i = 0; i < nbJours; i++) {
            for (int j = 0; j < nbCreneaux; j++) {
                emploiDuTemps[i][j] = rand.nextInt(nbSalles);
            }
        }
        evaluerEmploiDuTemps(getEmploiDuTemps(), getNbViolations());
        copierEmploiDuTemps(getEmploiDuTemps(), getMeilleurEmploiDuTemps());
        copierNbViolations(getNbViolations(), getMeilleurNbViolations());
    }

    public void evaluerEmploiDuTemps(int[][] emploiDuTemps, int[] nbViolations) {
        int totalNbViolations = 0;
        for (int i = 0; i < nbCours; i++) {
            nbViolations[i] = 0;
            for (int j = 0; j < nbJours; j++) {
                for (int k = 0; k < nbCreneaux; k++) {
                    if (i < contraintesCours.length && j < contraintesCours[i].length && k < contraintesCours[i][j].length && emploiDuTemps[j][k] == contraintesCours[i][j][k]) {
                        nbViolations[i]++;
                    }
                    if (emploiDuTemps[j][k] == emploiDuTemps[i][(k + 1) % this.nbCreneaux]) {
                        nbViolations[i]++;
                    }
                    if (emploiDuTemps[j][k] == emploiDuTemps[(j + 1) % this.nbJours][k]) {
                        nbViolations[i]++;
                    }
                    if (emploiDuTemps[j][k] == emploiDuTemps[(j + 1) % this.nbJours][(k + 1) % this.nbCreneaux]) {
                        nbViolations[i]++;
                    }
                }
            }
            totalNbViolations += nbViolations[i];
        }
        nbViolations[getNbCours()] = totalNbViolations;
    }


    public void copierEmploiDuTemps(int[][] source, int[][] dest) {
        for (int i = 0; i < this.nbJours; i++) {
            for (int j = 0; j < this.nbCreneaux; j++) {
                dest[i][j] = source[i][j];
            }
        }
    }

    public void copierNbViolations(int[] source, int[] dest) {
        for (int i = 0; i < this.nbCours + 1; i++) {
            dest[i] = source[i];
        }
    }
    public void iterationSurUnCoup() {
        int i = rand.nextInt(nbJours);
        int j = rand.nextInt(nbCreneaux);
        int k = rand.nextInt(nbSalles);

        int[][] nouveauEmploiDuTemps = new int[nbJours][nbCreneaux];
        copierEmploiDuTemps(emploiDuTemps, nouveauEmploiDuTemps);

        nouveauEmploiDuTemps[i][j] = k;
        int[] nouveauNbViolations = new int[nbCours + 1];
        evaluerEmploiDuTemps(nouveauEmploiDuTemps, nouveauNbViolations);

        int deltaViolations = nouveauNbViolations[nbCours] - nbViolations[nbCours];

        if (deltaViolations < 0) {
            copierEmploiDuTemps(nouveauEmploiDuTemps, emploiDuTemps);
            copierNbViolations(nouveauNbViolations, nbViolations);
            if (nbViolations[nbCours] < meilleurNbViolations[nbCours]) {
                copierEmploiDuTemps(nouveauEmploiDuTemps, meilleurEmploiDuTemps);
                copierNbViolations(nouveauNbViolations, meilleurNbViolations);
            }
        } else if (rand.nextDouble() < Math.exp(-deltaViolations / 10)) {
            copierEmploiDuTemps(nouveauEmploiDuTemps, emploiDuTemps);
            copierNbViolations(nouveauNbViolations, nbViolations);
        }
    }


    public void rechercheLocale() {
        evaluerEmploiDuTemps(emploiDuTemps, nbViolations);
        copierEmploiDuTemps(emploiDuTemps, meilleurEmploiDuTemps);
        copierNbViolations(nbViolations, meilleurNbViolations);

        int nbIterations = 0;
        int nbIterationsSansAmelioration = 0;
        while (nbIterationsSansAmelioration < MAX_NB_ITERATIONS_SANS_AMELIORATION) {
            iterationSurUnCoup();
            nbIterations++;
            if (aAmelioreSolution()) {
                copierEmploiDuTemps(emploiDuTemps, meilleurEmploiDuTemps);
                copierNbViolations(nbViolations, meilleurNbViolations);
                nbIterationsSansAmelioration = 0;
            } else {
                nbIterationsSansAmelioration++;
            }
        }
    }

    private boolean aAmelioreSolution() {
        if (nbViolations[nbCours] < meilleurNbViolations[nbCours] || (nbViolations[nbCours] == meilleurNbViolations[nbCours] && nbViolations[0] < meilleurNbViolations[0])) {
            return true;
        }
        return false;
    }
    public void optimiser() {
        initialiserEmploiDuTemps();
        initialiserContraintesSalle();
        rechercheLocale();
    }

    private void initialiserContraintesSalle() {
        for (int i = 0; i < nbCours; i++) {
            for (int j = 0; j < nbJours; j++) {
                for (int k = 0; k < nbCreneaux; k++) {
                    contraintesSalle[i][j][k] = rand.nextInt(nbSalles);
                }
            }
        }
    }

};