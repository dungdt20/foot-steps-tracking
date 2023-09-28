// Java program to illustrate 
// ThreadPool
import java.text.SimpleDateFormat;
import java.util.*;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;

record Event(long userId, int addPoints) {
}

// Task class to be executed (Step 1)
class Task implements Runnable {
    private final List<Event> events;

    public Task(List<Event> events) {
        this.events = events;
    }

    // Prints task and sleeps for 1s
    public void run() {
        try {
            if (events.isEmpty()) {
                System.out.println("Thread complete with empty list");
                return;
            }

            long userId = events.get(0).userId();
            Date date = new Date();
            SimpleDateFormat format = new SimpleDateFormat("hh:mm:ss");

            System.out.println("Initialization Time for user id: "
                    + userId + " = " + format.format(date));

            int sum = 0;
            for (Event event : events) {
                Date exeDate = new Date();
                SimpleDateFormat exeFormat = new SimpleDateFormat("hh:mm:ss");

                System.out.println("Executing Time for user id: " + event.userId()
                        + ", points: " + event.addPoints()
                        + " = " + exeFormat.format(exeDate));

                sum += event.addPoints();
                Thread.sleep(1000);
            }

            System.out.println("-- Complete calcutate thread of user id: " + userId + ", and sum points = " + sum);
        } catch(InterruptedException e) {
            e.printStackTrace();
        }
    }
}

public class ThreadPool {
    // Maximum number of threads in thread pool
    static final int MAX_THREAD = 3;

    public static void main(String[] args) {

        List<Event> events = initEvents();
        List<List<Event>> distributedEvents = distributeEventPerUser(events);

        // creates a thread pool with MAX_THREAD no. of
        // threads as the fixed pool size(Step 2)
        ExecutorService pool = Executors.newFixedThreadPool(MAX_THREAD);

        // passes the Task objects to the pool to execute (Step 3)
        for (List<Event> eventPerUser : distributedEvents) {
            Runnable task = new Task(eventPerUser);
            pool.execute(task);
        }

        // pool shutdown ( Step 4)
        pool.shutdown();
    }

    private static List<Event> initEvents() {
        final int NUM_EVENT = 10;
        int indexEvent = 0;

        List<Event> result = new ArrayList<>();

        while (indexEvent < NUM_EVENT) {
            indexEvent++;
            long userId = (long) genRandom(1, 5);
            int addPoints = genRandom(10, 100);
            result.add(new Event(userId, addPoints));
        }

        return result;
    }

    private static List<List<Event>> distributeEventPerUser(List<Event> events) {
        Map<Long, List<Event>> map = new HashMap<>();
        for (Event event : events) {
            long userId = event.userId();
            List<Event> eventsOfUser = map.computeIfAbsent(userId, k -> new ArrayList<>());

            eventsOfUser.add(event);
        }

        return new ArrayList<>(map.values());
    }

    private static int genRandom(int min, int max) {
        return (int) Math.floor(Math.random() * (max - min + 1) + min);
    }
}