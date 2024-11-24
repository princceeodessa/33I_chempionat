using System.ComponentModel;
using System.Runtime.CompilerServices;
using System.Text;
using BitMiracle.Docotic.Pdf;
using helpers;
using models;
using MySql.Data.MySqlClient;
BitMiracle.Docotic.LicenseManager.AddLicenseData("7LZR7-9LLYF-UDPFT-TNNPN-B06W8"); // license for bib

new PDFParser();

partial class PDFParser
{
    private readonly string _testFilePath = "pdfs/II_chast_EKP_2024_14_11_24_65c6deea36.pdf";
    private readonly HelperFormat helperFormat = new();
    private HashSet<RecordWithFormatting> _records = new();
    string connStr = "server=localhost;port=3306;username=root;password=;database=asd"; //твои настройки в пхпадмине

    public PDFParser()
    {
        ParsePDFPageRows();
    }
    
    private async void ParsePDFPageRows()
    {
        using (var pdf = new PdfDocument(_testFilePath))
        {
            var page = pdf.Pages[2];
            string pageText = page.GetText();
            //Console.WriteLine(pageText);
            string[] text = pageText.Split(new[] { '\n', '\r', ' ' }, StringSplitOptions.RemoveEmptyEntries);

            bool startDate = false;

            List<Format> record = new List<Format>();
            long code = 0;
            string name = "";
            DateTime start = DateTime.Now;
            DateTime end = DateTime.Now;
            string other = "";

            

            for (int i = 0; i < text.Length; i++)
            {
                if (helperFormat.IsCode(text[i]) && text[i].Length > 9)
                {
                    Format format = new Format();
                    format.code = code;
                    format.name = name;
                    format.start = start;
                    format.end = start;
                    format.other = other;
                    record.Add(format);
                    code = 0;
                    name = "";
                    start = default;
                    end = default;
                    other = "";
                    code = Convert.ToInt64(text[i]);
                    startDate = false;
                }

                else if (helperFormat.IsDate(text[i]) && startDate == false)
                {
                    start = DateTime.Parse(text[i]);
                    startDate = true;
                }
                else if (helperFormat.IsDate(text[i]) && startDate == true)
                {
                    end = DateTime.Parse(text[i]);
                }
                else if (startDate == false && helperFormat.IsUpperAll(text[i]))
                {
                    name += text[i] + " ";
                }
                else
                {
                    other += text[i] + " ";
                }
            }

            using (var conn = new MySqlConnection(connStr))
            {
                conn.Open();
                try
                {
                    foreach (var VARIABLE in record)
                    {
                        string q =
                            $"INSERT INTO `your_table_name`(`code`, `name`, `start_date`, `end_date`, `other`) VALUES (@code, @name, @start, @end, @other)"; // тут бля видимо чего не работает
                        MySqlCommand cmd = new MySqlCommand(q, conn);
                        cmd.Parameters.AddWithValue("@code", VARIABLE.code);
                        cmd.Parameters.AddWithValue("@name", VARIABLE.name);
                        cmd.Parameters.AddWithValue("@start", VARIABLE.start.ToString("d"));
                        cmd.Parameters.AddWithValue("@end", VARIABLE.end.ToString("d"));
                        cmd.Parameters.AddWithValue("@other", VARIABLE.other);
                        await cmd.ExecuteNonQueryAsync();
                    }
                }
                catch (Exception e)
                {
                    Console.WriteLine(e.Message);
                    Console.WriteLine(e.HelpLink);
                    throw;
                }
            }
            
        }
    }
}

public class Format
{
    public long code = 0;
    public string name = "";
    public DateTime start = default;
    public DateTime end = default;
    public string other = "";
}
