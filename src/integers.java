

public class LinearSearchApp
{
    static void Main()
    {
        int[] numbers = { 10, 5, 8, 3, 7, 2, 1, 6, 4, 9 };
        Console.Write("Enter a number to search: ");
        int searchValue = Convert.ToInt32(Console.ReadLine());

        boolean found = false;

        for (int i = 0; i < numbers.Length; i++)
        {
            if (numbers[i] == searchValue)
            {
                Console.WriteLine("Element found at position " + i);
                found = true;
                break;
            }
        }

        if (!found)
        {
            Console.WriteLine("Element not found");
        }
    }
}

